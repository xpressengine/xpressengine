{{xe_trans('xe::emailConfirm')}}: {{ route('auth.confirm', ['email' => $mail->address, 'code' => $mail->confirmationCode]) }}
