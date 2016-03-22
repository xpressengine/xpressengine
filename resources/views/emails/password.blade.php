이 링크로 이동하여 비밀번호를 재설정하세요: {{ route('auth.password', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]) }}
