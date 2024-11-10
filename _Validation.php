<?php

#Обновляем данные пользователя
public function update(Request $request, $id)
{   
    $user = User::find($id);

    $this->validate($request, [
        'name' => 'required',
        'avatar' => 'nullable|image',

        #Исключение правила валидации уникального 'email' занятого пользователем
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
    ]);

    $user->edit($request->all());
    $user->generatePassword($request->get('password'));
    $user->uploadAvatar($request->file('avatar'));

    return redirect()->route('users.index');
}
