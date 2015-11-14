이메일 인증: {{ route('auth.confirm', ['email' => $mail->address, 'code' => $mail->confirmationCode]) }}
