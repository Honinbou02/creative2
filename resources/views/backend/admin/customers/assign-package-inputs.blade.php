<x-common.message class="mb-3" /> 
<input type="hidden" name="id" value="{{ $customer->id }}">
<div class="mb-3">
    <x-form.label for="name" label="{{ localize('Name') }}" />
    <x-form.input name="name" id="name" type="text" placeholder="{{ localize('Name') }}" value="{{ $customer->name }}" showDiv=false disabled />
</div>

<div class="mb-3">
    <x-form.label for="assign_subscription_plan_id" label="{{ localize('Subscription Plan') }}" isRequired=true /> 
    <x-form.select name="assign_subscription_plan_id" class="subscriptionPlanOption" id="assign_subscription_plan_id">
        <option value="">{{localize('Select Subscription Plan')}}</option>
        @foreach ($plans as $plan)
            <option value="{{ $plan->id }}" data-price="{{ $plan->price }}">{{ $plan->title }} [{{localize('Price')}} ({{$plan->price}}) ] [<span class="text-capitalize">{{$plan->package_type}}</span>]</option>
        @endforeach
    </x-form.select>
</div> 
        
<div class="mb-3">
    <div class="form-check form-check-inline">
        <input class="form-check-input is_paid_assign_package" name="is_paid_assign_package" type="radio" value="paid" id="paid_assign_package" checked="">
        <label class="form-check-label" for="paid_assign_package">{{localize('Paid')}}</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input is_paid_assign_package" name="is_paid_assign_package" type="radio" value="free" id="free_assign_package">
        <label class="form-check-label" for="free_assign_package">{{localize('Free')}}</label>
    </div>
</div>

<div class="assign-payment-option" id="assign-payment-option">
    <div class="mb-3">
        <x-form.label for="assign_payment_method" label="{{ localize('Payment Method') }}" />
        <x-form.select name="assign_payment_method" id="assign_payment_method">
            <option value="">{{localize('Select Payment Method')}}</option>
            @foreach ($payment_gateways as  $gateway)
                <option class="text-capitalize" value="{{ $gateway->id }}"  data-gateway="{{$gateway->gateway}}">{{ $gateway->gateway }}</option>
            @endforeach
        </x-form.select>
    </div>       
    <div class="offline-wrapper mb-3 d-none">
        <x-form.label for="assign_offline_payment_method" label="{{ localize('Offline Payment Method') }}" />
        <x-form.select name="assign_offline_payment_method" id="assign_offline_payment_method">
            <option value="">{{localize('Offline Payment Method')}}</option>
            @foreach ($offlinePaymentMethods as  $offlinePaymentMethod)
                <option class="text-capitalize" value="{{ $gateway->id }}">{{ $offlinePaymentMethod->name }}</option>
            @endforeach
        </x-form.select>
    </div>           

    <div class="mb-3">
        <x-form.label for="assign_payment_amount" label="{{ localize('Payment Amount') }}" />
        <x-form.input name="assign_payment_amount" id="assign_payment_amount" type="number" step="0.001" placeholder="{{ localize('Payment Amount') }}" showDiv=false />
    </div>

    <div class="mb-3">
        <x-form.label for="assign_payment_detail" label="{{ localize('Payment Detail') }}" />
        <x-form.textarea name="assign_payment_detail" id="assign_payment_detail" type="text" placeholder="{{ localize('Payment Detail') }}" value="" showDiv=false />
    </div> 
</div>
<div class="mb-4">
    <div class="form-check tt-checkbox ps-0">
        <label for="forceful_expiration" class="form-check-label fw-medium ">
            <strong>{{localize('Old Package Disable')}}:</strong> {{ localize('Previously activated package (if have any) will be forcefully expired & this package will be activated.') }}
        </label>
    </div>
</div>