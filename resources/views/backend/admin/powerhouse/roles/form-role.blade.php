<div class="row">
    <div class="col-lg-4">
        <div class="mb-3">
            <label for="text-input" class="form-label">{{localize('Title')}} <?= showRequiredStar() ?>  </label>
            <input
                class="form-control"
                type="text"
                id="text-input"
                name="title"
                value="{{ isset($role) ? $role->title : old('title')}}"
                placeholder="{{ localize("Ex. Admin/Merchant/Customer") }}"
            />

            <?= errorName('title') ?>
        </div>
    </div>

    @include("admin.powerhouse.roles.group-permissions")

    @include("admin.includes.form-active-field",["active"=> isset($role) ? $role->is_active : 0])

</div>


@include("admin.includes.form-submit-cancel",["button"=>$button, "cancelRoute" => isset($cancelRoute) ? $cancelRoute : null])
