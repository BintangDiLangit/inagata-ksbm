<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseControllerAPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserControllerAPI extends BaseControllerAPI
{
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string', 'max:255'],
		]);

		if ($validator->fails()) {
			return $this->responseError('Login Failed', 422, $validator->errors());
		}

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			$user = Auth::user();
			$response = [
				'token' => $user->createToken('MyToken')->accessToken,
				'nama_user' => $user->nama_user,
				'username' => $user->username,
				'email' => $user->email,
				'nomor_hp' => $user->nomor_hp,
			];

			return $this->responseOk($response);
		} else {
			return $this->responseError('Wrong email or password', 401, $validator->errors());
		}
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'nama_user' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
			'nomor_hp' => ['required', 'string', 'max:255', 'unique:users'],
		]);

		if ($validator->fails()) {
			return $this->responseError('Registration Failed', 422, $validator->errors());
		}

		$params = [
			'email' => $request->email,
			'nama_user' => $request->nama_user,
			'username' => $request->username,
			'password' => Hash::make($request->password),
			'nomor_hp' => $request->nomor_hp,
		];

		if ($user = User::create($params)) {
			$token = $user->createToken('MyToken')->accessToken;
			$response = [
				'token' => $token,
				'user' => $user,
			];

			return $this->responseOk($response);
		} else {
			return $this->responseError('Registration failed', 400);
		}
	}
	public function fetch(Request $request)
	{
		return $this->responseOk($request->user());
	}

	public function updateProfile(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['string', 'email', 'max:255', 'unique:users'],
			'nama_user' => ['string', 'max:255'],
			'username' => ['string', 'max:255', 'unique:users'],
			'oldpassword' => ['string', 'min:8', 'max:255'],
			'newpassword' => ['string', 'min:8', 'max:255', 'confirmed'],
			'nomor_hp' => ['string', 'max:255', 'unique:users'],
		]);

		if ($validator->fails()) {
			return $this->responseError('Registration Failed', 422, $validator->errors());
		}

		$data = $request->all();
		$user = Auth::user();


		$hashedPassword = Auth::user()->password;
		if ($request->oldpassword != null && $request->newpassword != null) {
			if (Hash::check($request->oldpassword, $hashedPassword)) {

				if (!Hash::check($request->newpassword, $hashedPassword)) {

					$users = User::find(Auth::user()->id);
					$users->password = bcrypt($request->newpassword);
					User::where('id', Auth::user()->id)->update(array('password' =>  $users->password));
					$user->update($data);
					return $this->responseOk('Data User dan Password berhasil diupdate');
				} else {
					return $this->responseError('Password tidak boleh sama dari yang lama', 400);
				}
			} else {
				return $this->responseError('Password lama tidak cocok', 400);
			}
		}

		$user->update($data);
		return $this->responseOk($user, 'Data user berhasil diupdate');
	}

	public function logout(Request $request)
	{
		$request->user()->token()->revoke();
		return $this->responseOk('Logged Out');
	}
}
