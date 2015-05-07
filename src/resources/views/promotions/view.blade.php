@extends('redminportal::layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('redminportal::menus.home') }}</a></li>
                <li class="active">{{ Lang::get('redminportal::menus.promotions') }}</li>
            </ol>
        </div>
    </div>

    @include('redminportal::partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                <div class="btn-group" role="group">
                @if (count($promotions) > 0)
                <a href="" class="btn btn-default btn-sm disabled btn-text">{{ $promotions->firstItem() . ' to ' . $promotions->lastItem() . ' of ' . $promotions->total() }}</a>
                @endif
                {!! HTML::link('admin/promotions/create', Lang::get('redminportal::buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
            </div>
        </div>
    </div>
    
    @if (count($promotions) > 0)
        <table class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Promotions and Events</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($promotions as $promotion)
                <tr>
                    <td>
                        {{ $promotion->name }}
                    </td>
                    <td>{{ $promotion->start_date }}</td>
                    <td>{{ $promotion->end_date }}</td>
                    <td>
                        @if ($promotion->active)
                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                        @else
                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                        @endif
                    </td>
                    <td class="table-actions text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-option-horizontal"></span>
							</button>
						  	<ul class="dropdown-menu pull-right" role="menu">
						        <li>
						            <a href="{{ URL::to('admin/promotions/edit/' . $promotion->id) }}">
						                <i class="glyphicon glyphicon-edit"></i>Edit</a>
						        </li>
						        <li>
						            <a href="{{ URL::to('admin/promotions/delete/' . $promotion->id) }}" class="btn-confirm">
						                <i class="glyphicon glyphicon-remove"></i>Delete</a>
						        </li>
						  	</ul>
						</div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-center">
        {!! $promotions->render() !!}
        </div>
    @else
        <div class="alert alert-info">No promotion found</div>
    @endif
@stop
