{{xe_trans('xe::moveAndResetPassword')}}: {{ route('auth.password', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]) }}
