@extends('redminportal::layouts.master')

@section('content')
    @if($errors->has())
    <div class='alert alert-danger'>
        We encountered the following errors:
        <ul>
            @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="nav-controls text-right">
        @if (count($discounts) > 0)
        <span class="label label-default pull-left">
            {{ $discounts->getFrom() . ' to ' . $discounts->getTo() . ' ( total ' . $discounts->getTotal() . ' )' }}
        </span>
        <br>
        @endif
    </div>
    
    <table class='table table-striped table-bordered'>
        <thead>
            <tr>
                <th>Module (Membership)</th>
                <th>Discount Code</th>
                <th>Discount Percentage</th>
                <th>Discount Expiry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ Form::select('pricelist_id', $pricelists_select, Input::old('pricelist_id'), array('class' => 'form-control', 'id' => 'pricelist_id_input')) }}</td>
                <td>{{ Form::text('code', Input::old('code'), array('class' => 'form-control', 'id' => 'code_input')) }}</td>
                <td><input type="number" id="percent_input" name="percent" class="form-control" min="1" max="100"></td>
                <td>{{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control datepicker', 'readonly', 'id' => 'expiry_date_input')) }}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-xs btn-add"><span class="glyphicon glyphicon-plus"></span> Add</a>
                </td>
            </tr>
            @if (count($discounts) > 0)
                @foreach ($discounts as $discount)
                    <tr>
                        <td>{{ $discount->discountable->module->name }} ({{ $discount->discountable->membership->name }})</td>
                        <td>
                            {{ $discount->code }}
                        </td>
                        <td>
                            {{ $discount->percent }}
                        </td>
                        <td>
                            {{ $discount->expiry_date }}
                        </td>
                        <td>
                            <a href="{{ URL::to('admin/discounts/delete/' . $discount->id) }}" class="btn btn-danger btn-xs btn-confirm">
                                <span class="glyphicon glyphicon-remove"></span> Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if (count($discounts) > 0)
        <div class="text-center">
        {{ $discounts->links() }}
        </div>
    @endif
    {{ Form::open(array('action' => 'Redooor\Redminportal\DiscountController@postStore', 'role' => 'form', 'id' => 'form_add')) }}
        {{ Form::hidden('pricelist_id', Input::old('pricelist_id'), array('id' => 'pricelist_id')) }}
        {{ Form::hidden('code', Input::old('code'), array('id' => 'code')) }}
        {{ Form::hidden('percent', Input::old('percent'), array('id' => 'percent')) }}
        {{ Form::hidden('expiry_date', Input::old('expiry_date'), array('id' => 'expiry_date')) }}
    {{ Form::close() }}
    @if (count($discounts) == 0)
        <div class="alert alert-info">No discount found</div>
    @endif
@stop

@section('footer')
    <script>
        !function ($) {
            $(function(){
                // Date picker
                $( ".datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });

                $( "#expiry-date .input-group-addon" ).click( function() {
                    $( "#expiry-date" ).datepicker( "show" );
                });

                $(document).on('click', '.btn-add', function(e) {
                    e.preventDefault();
                    $('#pricelist_id').val($('#pricelist_id_input').val());
                    $('#code').val($('#code_input').val());
                    $('#percent').val($('#percent_input').val());
                    $('#expiry_date').val($('#expiry_date_input').val());
                    $('#form_add').submit();
                });
            });
        }(window.jQuery);
    </script>
@stop