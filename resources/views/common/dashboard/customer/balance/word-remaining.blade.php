@if (isCustomerUserGroup())
    @php
        $totalWordBalance     = userActivePlan()["word_balance"] ?? 0;
        $totalWordUsed        = userActivePlan()["word_balance_used"] ?? 0;
        $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
    @endphp
    <div class="d-flex align-items-center flex-column mt-4">
        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                <span class="fs-base"><strong>{{$totalRemainingBalance}}</strong> {{localize('Used out of')}} <strong>{{$totalWordBalance}}</strong>
                                                    {{localize('words')}}.</span>
        </div>
        <div class="progress mb-2 w-100" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{100 - percentageUsed($totalWordUsed,$totalWordBalance)}}%"
                 aria-valuenow="{{percentageUsed($totalWordUsed,$totalWordBalance)}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
@endif