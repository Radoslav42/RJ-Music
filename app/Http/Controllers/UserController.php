<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;


// verejne before funckie su get funkcie, verejne funkcie bez before su post metody alebo metody pre presmerovanie ako logout
// privatne metody su pre priamu komunikaciu s databazou alebo pre kontrolu parametrov z metod post
class UserController extends Controller
{
    private function existUserByUsernameOrEmail(string $nameOrEmail) : bool
    {
        if ($nameOrEmail != null) {
            return (User::all()->where('username', '=', $nameOrEmail)->count() > 0
                    || User::all()->where('email', '=', $nameOrEmail)->count()) > 0;
        }
        return false;
    }
    private function existUserById(int $id) : bool
    {
        return (User::all()->where('id', '=', $id)->count() > 0);
    }
    private function getUserById(int $id) : User
    {
        if (User::all()->where('id', '=', $id)->count() > 0)
        {
            return User::all()->where('id', '=', $id)->first();
        }
        throw new Exception("User with id=$id does not exist!");
    }
    private function getUserByUsernameOrEmail(string $nameOrEmail) : User
    {
        if (User::all()->where('username', '=', $nameOrEmail)->count() > 0)
        {
            return User::all()->where('username', '=', $nameOrEmail)->first();
        }
        else if (User::all()->where('email', '=', $nameOrEmail)->count() > 0)
        {
            return User::all()->where('email', '=', $nameOrEmail)->first();
        }
        throw new Exception("Name or email does not exist!");
    }
    private function validateStringLengthFrom3To50Characters(string $str) : bool
    {
        if (strlen($str) >= 3 && strlen($str) <= 50)
            return true;
        else {
            session()->put('sessionMessage', "Wrong string length!");
            return false;
        }
    }
    private function validateEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isLoggedUser() : bool
    {
        return session()->has('loggedUser');
    }
    public function beforeSendMailForRecoveryPassword()
    {
        $view = view('mailRecoveryPassword', ['titleText' => "Poslanie mailu pre obnovu hesla", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        return $view;
    }
    private function pSendMailForRecoveryPassword(string $email) : bool
    {
        try {
            if ( $userVerification = DB::table('user_verifications')
                ->where('email', $email)->count() > 0)
            {
                DB::delete("delete from user_verifications where email = ?" , [$email]);
            }
            //Create Password Reset Token
            DB::table('user_verifications')->insert([
                'email' => $email,
                'token' => Str::random(60),
                'createdAt' => Carbon::now()
            ]);
            //Get the token just created above
            $userVerification = DB::table('user_verifications')
                ->where('email', $email)->first();
            $user = $this->getUserByUsernameOrEmail($email);
            $username = $user->getAttribute('username');
            $url = action([UserController::class, 'beforeChangePassword'], ['token' => $userVerification->token, 'email' => $email]);
            $parameters = array('username' => $username, "description" => "Click on link for recovery password:", 'verificationLink' => $url);
            $this->sendMail('emails/userVerificationMail', "RJ-Music recovery password",
                $parameters, "RJ-Music", "radkojoob1@gmail.com", $username, $email);
        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
    }
    public function sendMailForRecoveryPassword()
    {
        $email = request('email');
        if ($this->validateStringLengthFrom3To50Characters($email) && $this->validateEmail($email))
        {
            //bolo by do buducna doble aj daco z mac adresou pre token
            //$macAddress = exec('getmac');
            if ($this->existUserByUsernameOrEmail($email))
            {
                if ($this->pSendMailForRecoveryPassword($email))
                {
                    session()->put('sessionMessage', "A reset link has been sent to your email address.");
                    return redirect('/beforeLogin');
                }
                else
                {
                    session()->put('sessionMessage', "A Network Error occurred. Please try again.");
                }
            }
            else
            {
                session()->put('sessionMessage', "Email does not exist!");
            }
        }
        else
        {
            session()->put('sessionMessage', "Wrong input!");
        }
        return redirect('/beforeSendMailForRecoveryPassword');
    }
    private function removeUserToken()
    {

    }
    public function beforeChangePassword()
    {
        if (!UserController::isLoggedUser())
        {
            $email = request('email');
            $token = request('token');
            $ret = $this->pVerifyUserEmail($email, $token, false, 30);
            session()->put('sessionMessage', $ret);
            if ($ret == "Verification was successfully completed!") {
                return view('changePassword', ['titleText' => "Zmena hesla", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                    'token' => !UserController::isLoggedUser() ? $token : null]);
            }
            else
            {
                return redirect('/beforeLogin');
            }
        }
        else
        {
            $user = session()->get('loggedUser', [User::class]);
            $authorId = $user->getAttribute('authorId');
            if ($authorId != null)
            {
                $author = AuthorController::getAuthorById($authorId);
            }
            $view =  view('changePassword', ['titleText' => "Zmena hesla",
                'imageFilename' => "Author" . $user->getAttribute('authorId') . "Image",
                'firstname' => $authorId != null ? $author->getAttribute('firstname') : "",
                'lastname' => $authorId != null ? $author->getAttribute('lastname') : "",
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                'token' => null]);
            session()->put('sessionMessage', "");
            return $view;
        }
    }
    private function deleteUserVerificationByToken(string $token)
    {
        DB::delete("delete from user_verifications where token = ?" , [$token]);
    }
    public function changePassword()
    {
        $newPassword = request('newPassword');
        $retypeNewPassword = request('retypeNewPassword');
        if (!$this->validateStringLengthFrom3To50Characters($newPassword) && !$this->validateStringLengthFrom3To50Characters($retypeNewPassword))
        {
            session()->put('sessionMessage', "Wrong input!");
        }
        if (UserController::isLoggedUser())
        {
            $oldPassword = request('oldPassword');
            if ($this->validateStringLengthFrom3To50Characters($oldPassword))
            {
                $user = session()->get('loggedUser', [User::class]);
                $hashedPassword = $user->getAttribute('password');
                if (Hash::check($oldPassword, $hashedPassword))
                {
                    if ($newPassword == $retypeNewPassword) {
                        $hashedPassword = Hash::make($newPassword);
                        $user->setAttribute('password', $hashedPassword);
                        $user->save();
                        session()->put('sessionMessage', "Password has successfully changed!");
                    }
                    else
                    {
                        session()->put('sessionMessage', "New password and new retyped password are different!");
                    }
                }
                else
                {
                    session()->put('sessionMessage', "Wrong password!");
                }
            }
            else
            {
                session()->put('sessionMessage', "Wrong input!");
            }
            return redirect('/beforeChangePassword');
        }
        else
        {
            $token = request('token');
            if ( DB::table('user_verifications')->where('token', $token)->count() > 0)
            {
                $email = DB::table('user_verifications')->where('token', $token)->first()->email;
                if ($newPassword == $retypeNewPassword) {
                    $hashedPassword = Hash::make($newPassword);
                    $user = $this->getUserByUsernameOrEmail($email);
                    $user->setAttribute('password', $hashedPassword);
                    $user->save();
                    session()->put('sessionMessage', "Password has successfully changed!");
                    $this->deleteUserVerificationByToken($token);
                }
                else
                {
                    session()->put('sessionMessage', "New password and new retyped password are different!");
                    return redirect(action([UserController::class, 'beforeChangePassword'], ['token' =>  $token, 'email' => $email]));
                }
            }
            return redirect('/beforeLogin');
        }
    }
    public function beforeLogin()
    {
        if (UserController::isLoggedUser())
        {
            return redirect('beforeUpdateUser');
        }
        else
        {
            $view = view('login', ['titleText' => "Prihlásenie", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
            session()->put('sessionMessage', "");
            return $view;
        }
    }

    public function beforeRegistration()
    {
        $view = view('registration', ['titleText' => "Registrácia", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        return $view;
    }

    public function login()
    {
        $nameOrEmail = request('user_name_mail');
        if ($this->existUserByUsernameOrEmail($nameOrEmail))
        {
            if ($this->validateStringLengthFrom3To50Characters($nameOrEmail)) {
                $user = $this->getUserByUsernameOrEmail($nameOrEmail);
                if ($user->getAttribute('emailVerifiedAt') != null) {
                    $hashedPassword = $user->getAttribute('password');
                    //https://laravel.com/docs/5.0/hashing
                    if (Hash::check(request('password'), $hashedPassword)) {
                        session()->put('loggedUser', $user);
                        return redirect('/beforeUpdateUser');
                    } else {
                        session()->put('sessionMessage', "Wrong username or password!");
                        return redirect('/beforeLogin');
                    }
                }
                else
                {
                    session()->put('sessionMessage', "Wrong username or password!");
                    return redirect('/beforeLogin');
                }
            }
            else
            {
                session()->put('sessionMessage', "Wrong input!");
                return redirect('/beforeLogin');
            }
        }
        else {
            session()->put('sessionMessage', "Wrong username or password!");
            return redirect('/beforeLogin');
        }

    }
    public function logout()
    {
        session()->remove('loggedUser');
        return redirect('/beforeLogin');
    }
    private function pVerifyUserEmail(string $email, string $token, bool $deleteUserVerification, int $limitMinutes = 0) : string
    {
        if (DB::table('user_verifications')->where('email', $email)->count() > 0)
        {
            $userVerification = DB::table('user_verifications')
                ->where('email', $email)->first();
            if ($token == $userVerification->token) {
                if ($limitMinutes != 0 && Carbon::parse($userVerification->createdAt)->addMinutes($limitMinutes) < Carbon::now())
                {
                    DB::delete("delete from user_verifications where token = ?" , [$token]);
                    return "Token has expired!";
                }
                $user = $this->getUserByUsernameOrEmail($email);
                if ($user->getAttribute('emailVerifiedAt') == null)
                {
                    $user->setAttribute('emailVerifiedAt', Carbon::now());
                    $user->save();
                }
                if ($deleteUserVerification)
                {
                    DB::delete("delete from user_verifications where token = ?", [$token]);
                }
                return "Verification was successfully completed!";
            } else {
                return "Token is wrong!";
            }
        }
        else
        {
            return "User does not exist!";
        }
    }
    public function verifyUserEmail()
    {
        $email = request('email');
        $token = request('token');
        if ($this->existUserByUsernameOrEmail($email))
        {
            $user = $this->getUserByUsernameOrEmail($email);
            $ret = $user->getAttribute('emailVerifiedAt') != null ? $this->pVerifyUserEmail($email, $token, true,30) : $this->pVerifyUserEmail($email,$token,true);
            session()->put('sessionMessage', $ret);
        }
        return redirect('/beforeLogin');
    }
    public function register()
    {
        $username = request('user_name');
        $email = request('email');
        $password = request('password');
        if ($this->validateStringLengthFrom3To50Characters($username) && $this->validateEmail($email) &&
            $this->validateStringLengthFrom3To50Characters($password)) {
            if (!$this->existUserByUsernameOrEmail($username) && !$this->existUserByUsernameOrEmail($email)) {
                //https://laravel.com/docs/5.0/hashing
                $hashedPassword = Hash::make($password);
                $user = new User();
                $user->setAttribute('username', $username);
                $user->setAttribute('email', $email);
                $user->setAttribute('password', $hashedPassword);
                $user->save();
                session()->put('sessionMessage', "User registration successfully allowed. Please click on link in verification mail which was send you.");

                DB::table('user_verifications')->insert([
                    'email' => $email,
                    'token' => Str::random(60),
                    'createdAt' => Carbon::now()
                ]);
                //Get the token just created above
                $userVerification = DB::table('user_verifications')
                    ->where('email', $email)->first();

                $url = action([UserController::class, 'verifyUserEmail'], ['token' =>  $userVerification->token, 'email' => $email]);
                $parameters = array('username'=> $username, "description" => "Click on link for activation user account:", 'verificationLink' => $url);
                $this->sendMail('emails/userVerificationMail', "RJ-Music verification user account",
                    $parameters, "RJ-Music", "radkojoob1@gmail.com", $username, $email);
                return redirect('/beforeLogin');
            } else {
                session()->put('sessionMessage', "User already exists!");
                return redirect('/beforeRegistration');
            }
        }
        session()->put('sessionMessage', "Wrong set input!");
        return redirect('/beforeRegistration');
    }
    public function sendMail(string $view, string $subject, $parameters, string $fromName, string  $fromEmail, string $toName, string  $toEmail) : bool
    {
        try {
            Mail::send($view, $parameters, function ($message) use ($fromName, $fromEmail, $toName, $toEmail, $subject) {
                $message->to($toEmail, $toName)
                    ->subject($subject);
                $message->from($fromEmail, $fromName);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function updateUser()
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
        }
        else
        {
            return redirect('/beforeLogin');
        }
        $username = request('username');
        $email = request('email');
        $usernameChanged = $username != $user->getAttribute('username');
        $emailChanged = $email != $user->getAttribute('email');
        if ($this->validateStringLengthFrom3To50Characters($username) && $this->validateEmail($email)
            && ($usernameChanged || $emailChanged))
        {
            if ((!$this->existUserByUsernameOrEmail($username) && !$emailChanged)
            || (!$this->existUserByUsernameOrEmail($email) && !$usernameChanged)
            || (!$this->existUserByUsernameOrEmail($username) && !$this->existUserByUsernameOrEmail($email) && $usernameChanged && $emailChanged))
            {
                $user->setAttribute('username', $username);
                $user->setAttribute('email', $email);
                $user->update();
                session()->put('sessionMessage', "User was successfully updated!");
            }
            else
            {
                session()->put('sessionMessage', "User with username or email already exist!");
            }
            return redirect('/beforeUpdateUser');
        }
        return redirect('/beforeUpdateUser');
    }
    public function beforeUpdateUser()
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $username = $user->getAttribute('username');
            $email = $user->getAttribute('email');
            $authorId = $user->getAttribute('authorId');
            if ($authorId != null)
            {
                $author = AuthorController::getAuthorById($authorId);
            }
            $view = view('user', ['titleText' => "Užívateľ",
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                'username' => $username, 'email' => $email, 'imageFilename' => "Author" . $user->getAttribute('authorId') . "Image",
                'firstname' => $authorId != null ? $author->getAttribute('firstname') : "",
                'lastname' => $authorId != null ? $author->getAttribute('lastname') : ""]);
        }
        else
        {
            $view = view('login', ['titleText' => "Prihlásenie", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        }
        session()->put('sessionMessage', "");
        return $view;
    }

}
