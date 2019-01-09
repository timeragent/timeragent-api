<?php

namespace App\Http\GraphQL\Mutations;

use App\Mail\Welcome;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterMutator
{
    use RegistersUsers, ValidatesRequests;

    public function createUser($root, $args, $context)
    {
        $message = $this->register($context->request);

        return [
            'message' => $message,
            'statusCode' => 200
        ];
    }

    public function register(Request $request)
    {
        $this->validator($request->variables)->validate();

        $user = $this->create($request->variables);

        Mail::to($user->email)->send(new Welcome($user));

        return 'User created successfully';
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'user.email' => 'required|email|max:255|unique:users,email',
            ]
        );
    }

    protected function create(array $data)
    {
        $data = $data['user'];
        $user = new User();
        $user->first_name = $data['firstName'];
        $user->last_name = $data['lastName'];
        $user->middle_name = $data['middleName'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->verification_token = 0;
        $user->save();



        return $user;
    }

    public function verifyEmail($root, $args)
    {
        $user = User::find($args['verificationCode']);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification code',
                'statusCode' => 500
            ], 500)->getData();
        }

        if ($user->verification_token !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already verified',
                'statusCode' => 500
            ], 500)->getData();
        }

        $user->verification_token = str_random(20);
        $user->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Email verified successfully',
                'statusCode' => 200
            ]
        )->getData();
    }
}
