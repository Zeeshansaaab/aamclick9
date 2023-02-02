@php
    // $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">Installments</x-slot>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Installments" title="Installments" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">Installments</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    <div class="card card-preview" style="width: 50%; border:1px solid #8080802b; margin:auto;">
        <div class="card-inner">
            @include('frontend.installment.form')
        </div>
    </div>
</x-app-layout>