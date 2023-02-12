@props([
    'user',
    'index'
])
<tr class="tb-tnx-item">
    <td class="tb-tnx-id">
        <a href="#"><span>{!!$index!!}</span></a>
    </td>
    <td class="tb-tnx-info">
        <div class="tb-tnx-desc">
            <span class="title">{{ $user->name }} - <span class="fw-bold text-primary">{{ $user->uuid }}</span></span>
        </div>
        <div class="tb-tnx-date">
            <span class="date">{{currency($user->planUser->balance)}}</span>
            <span class="date">{{currency($user->planUser->referral_income)}}</span>
        </div>
    </td>
</tr>