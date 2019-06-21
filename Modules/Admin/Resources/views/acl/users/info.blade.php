<table class="table table-bordered">
    <tbody>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.user_role') !!}</td>
        <td>{!! $user->role->name !!}</td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.user_email') !!}</td>
        <td>{!! $user->email !!}</td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.user_name') !!}</td>
        <td>{!! $user->name?:'Not Set' !!}</td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.language') !!}</td>
        <td>{!! $user->language->language?:'Not Set' !!}</td>
    </tr>
    <tr>
        <td>Password</td>
        <td>**********</td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.brands') !!}</td>
        <td><ul>
                @foreach($user->brands as $brand)
                    <li>{{$brand->name}}</li>
                @endforeach
            </ul></td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.countries') !!}</td>
        <td><ul>
                @foreach($user->countries as $country)
                    <li>{{$country->name}}</li>
                @endforeach
            </ul></td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.date_created') !!}</td>
        <td>{!! DateTimeHelper::display($user->created_at, 'short') !!}</td>
    </tr>
    <tr>
        <td>{!! trans('admin::userTranslations.form_edit.account_status') !!}</td>
        <td>{!! !empty($user->active)?'Active':'Disabled' !!}</td>
    </tr>
    </tbody>
</table>