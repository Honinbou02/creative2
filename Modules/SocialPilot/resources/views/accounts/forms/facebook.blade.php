<input type="hidden" name="platform_id" value="{{ $platform?->id }}">
<input type="hidden" name="type" value="{{ $platform?->slug }}">
<div class="mb-3">
    <x-form.label for="account_type" label="{{ localize('Account Type') }}" isRequired=true />
    <x-form.select name="account_type" id="account_type">
            <option value="profile" disabled class="text-danger">{{ localize("Profile") }}</option>
            <option value="1">{{ localize("Page") }}</option>
            <option value="2">{{ localize("Group") }}</option>
    </x-form.select>
    <i class="text-warning text-sm">** {{ localize("Facebook does not allow to post in personal profile through it's API")}}</i>
</div>

<div class="mb-3 page">
    <x-form.label for="page_id" label="{{ localize('Page ID') }}" isRequired=true />
    <x-form.input id="page_id" name="page_id" type="text" placeholder="{{ localize('Page ID') }}" showDiv=false  required/>
</div>

<div class="mb-3 group d-none">
    <x-form.label for="group_id" label="{{ localize('Group ID') }}" isRequired=true />
    <x-form.input id="group_id" name="group_id" type="text" placeholder="{{ localize('Group ID') }}" showDiv=false  required/>
</div>

<div class="mb-3">
    <x-form.label for="access_token" label="{{ localize('Access Token') }}" isRequired=true />
    <x-form.input id="access_token" name="access_token" type="text" placeholder="{{ localize('Access Token') }}" showDiv=false  required/>
</div>