<script>
    // handle package payment
    function handlePackagePayment($this) {

        let packageChangeCheck;
        let package_type            = $($this).data('package-type');
        let subscribed_package_type = $($this).data('previous-package-type');
        let check                   = true;
        let user_type               = $($this).data('user-type') == "Customer" ? 'Customer' : 'Admin';

        let carryForward = '{{ getSetting('carry_forward ') ? 1 : 0 }}';

        if ((subscribed_package_type == "prepaid" || subscribed_package_type == "lifetime") && (
            package_type != "prepaid" && package_type != "lifetime")) {
            packageChangeCheck = confirm(
                `{{ localize('You current package ${subscribed_package_type} will be expired if you want to subscribe to ${package_type}. Do you want to continue?') }}`
            )
        }

        if (subscribed_package_type != package_type && user_type == "Customer" && carryForward == "0") {
            check = confirm(
                `{{ localize('You are changing your subscription package type to ${package_type}, your balance will be reset with new package balance. Want to continue?') }}`
            )
        }

        if (check || packageChangeCheck) {
            let package_id = $($this).data('package-id');
            let price      = parseFloat($($this).data('price'));

            $('.payment_package_id').val(package_id);

            let isLoggedIn   = parseInt('{{ Auth::check() }}');
            let authUserType = 'Customer';

            if (isLoggedIn == 1) {
                let isCustomerUserGroup =  "{{ isCustomerUserGroup() ? 'true' : 'false' }}";

                console.log("is customer group", isCustomerUserGroup,"Price", price);

                if (isCustomerUserGroup == "true") {
                    if (price > 0) {
                        showPackagePaymentModal();
                    } else {
                        $('.payment-method-form').submit();
                    }
                } else {
                    var redirectLink =  "{{ route('admin.subscription-plans.index') }}";
                    $(location).prop('href', redirectLink)
                }
            } else {
                var redirectLink = "{{ route('admin.subscription-plans.index') }}";
                $(location).prop('href', redirectLink)
            }
        }
    }

    // show package payment modal
    function showPackagePaymentModal() {
        alert("Modal SHowing");
        $('#packagePaymentModal').modal('show');
    }
</script>