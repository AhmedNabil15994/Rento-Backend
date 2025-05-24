@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.show.title'))
@section('content')
  <style type="text/css" media="print">
  	@page {
  		size  : auto;
  		margin: 0;
  	}
  	@media print {
  		a[href]:after {
  		content: none !important;
  	}
  	.contentPrint{
  			width: 100%;
  		}
  		.no-print, .no-print *{
  			display: none !important;
  		}
  	}
  </style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.users.index')) }}">
                        {{__('user::dashboard.users.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('user::dashboard.users.show.title')}}</a>
                </li>
            </ul>
        </div>
 
        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#general">
                                    <i class="fa fa-cog"></i> {{ __('user::dashboard.users.create.form.general') }}
                                </a>

                            
                                <span class="after"></span>
                            </li>
                            @if($user->type == "office" && $user->office)
                                <li class="">
                                    
                                    <a data-toggle="tab" href="#office">
                                        <i class="fa fa-cog"></i> {{ __('user::dashboard.users.create.form.office') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                            @endif

                            @if($user->type == "office" && $user->currentSubscription)
                                    <li class="">
                                            
                                        <a data-toggle="tab" href="#currentSubscription">
                                            <i class="fa fa-cog"></i> {{ __('user::dashboard.users.datatable.currentSubscription.tab') }}
                                        </a>
                                        <span class="after"></span>
                                    </li>
                            @endif
                           

                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    @include('apps::dashboard.layouts._msg')
                    <div class="tab-content">
                        {{-- start --}}
                        <div class="tab-pane active" id="general">
                            <div class="invoice-content-2 busered">
                                <div class="row invoice-head">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="row invoice-logo">
                                            <div class="col-xs-6">
                                                <img src="{{ url($user->default_image ??  setting('favicon') ) }}" class="img-responsive" style="width:40%" />
                                                <span>
                                                    {{$user->name  }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="company-address">
                                            <h6 class="uppercase">#{{ $user['id'] }}</h6>
                                            <h6 class="uppercase">{{date('Y-m-d / H:i:s' , strtotime($user->created_at))}}</h6>
                                          
                                            <span class="bold">
                                                {{__('user::dashboard.users.datatable.mobile')}} :
                                            </span>
                                            @if($user)
                                                @if(locale() != "ar")
                                                    {{ '+'.$user->phone_code.$user->mobile }}
                                                    @else
                                                        {{ $user->phone_code.$user->mobile."+"  }}
                                                @endif
                                            @endif
                                            <br />
                                        </div>
                                    </div>
                                    <div class="row invoice-body" >
                                        <div class="col-xs-12 table-responsive" style="margin-top: 20px">
                                            <table class="table table-bordered ">
                                               
                                                <tbody>
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.name')}}
                                                        </td>
                                                        <td>
                                                            {{ $user->name ?? '-----' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.email')}}
                                                        </td>
                                                        <td>
                                                            {{ $user->email ?? '-----' }}
                                                        </td>
                                                    </tr>

                                                
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.status')}}
                                                        </td>
                                                        <td>
                                                         
                                                            @if ($user->is_active == 1) 
                                                                 <span class="badge badge-success"> {{__('apps::dashboard.datatable.available')}} </span>
                                                                @else
                                                                <span class="badge badge-danger"> {{__('apps::dashboard.datatable.unavailable')}} </span>
                                                              @endif  
                                                           
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.is_verified')}}
                                                        </td>
                                                        <td>
                                                         
                                                            @if ($user->is_verifed == 1) 
                                                                 <span class="badge badge-success"> {{__('apps::dashboard.datatable.yes')}} </span>
                                                                @else
                                                                <span class="badge badge-danger"> {{__('apps::dashboard.datatable.no')}} </span>
                                                              @endif  
                                                           
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.type')}}
                                                        </td>
                                                        <td>
                                                         
                                                            @if ($user->type == "user") 
                                                                 <span class="badge badge-success"> {{__('user::dashboard.users.datatable.'.$user->type)}} </span>
                                                                @else
                                                                <span class="badge badge-info"> {{__('user::dashboard.users.datatable.'.$user->type)}} </span>
                                                              @endif  
                                                           
                                                        </td>
                                                    </tr>

                                                    @if ($user->workerProfile)
                                                            <tr>
                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                    {{__('user::dashboard.workers.datatable.vendor_id')}}
                                                                </td>
                                                                <td>
                                                                    {{ optional($user->workerProfile->vendor)->translateOrDefault(locale())->title }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                    {{__('user::dashboard.workers.datatable.branch_id')}}
                                                                </td>
                                                                <td>
                                                                    {{ optional($user->workerProfile->branch)->translateOrDefault(locale())->title }}
                                                                </td>
                                                            </tr>
                                                    @endif


                                                    @if ($user->roles->count() > 0 )
                                                            <tr>
                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                    {{__('user::dashboard.admins.update.form.roles')}}
                                                                </td>
                                                                <td>
                                                                   @foreach ($user->roles as $role)
                                                                   <span class="badge badge-info"> {{$role->translateOrDefault(locale())->display_name}} </span>
                                                                   @endforeach
                                                                </td>
                                                            </tr>

                                                            
                                                    @endif
                                                   
                                                  
                                                  
                                                   

                                                  


                                                </tbody>
                                                <thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end --}}

                        @if($user->type == "office" && $user->office)
                            @php
                                $office = $user->office;
                            @endphp
                         {{-- start --}}
                         <div class="tab-pane " id="office">
                            <div class="invoice-content-2 busered">
                                <div class="row invoice-head">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="row invoice-logo">
                                            <div class="col-xs-6">
                                                <img src="{{ url($office->image ??  setting('favicon') ) }}" class="img-responsive" style="width:40%" />
                                                <span>
                                                    {{$office->title  }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="company-address">
                                           
                                          
                                            <span class="bold">
                                                {{__('user::dashboard.users.datatable.mobile')}} :
                                            </span>
                                            {{ $office->mobile}}
                                            <br />
                                        </div>
                                    </div>
                                    <div class="row invoice-body" >
                                        <div class="col-xs-12 table-responsive" style="margin-top: 20px">
                                            <table class="table table-bordered ">
                                               
                                                <tbody>
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.description')}}
                                                        </td>
                                                        <td>
                                                            {{ $office->description ?? '-----' }}
                                                        </td>
                                                    </tr>

                                                    @if( $office->country)
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.country_id')}}
                                                        </td>
                                                        <td>
                                                            {{ $office->country->translateOrDefault(locale())->title }}
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    @if( $office->city)
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.city_id')}}
                                                        </td>
                                                        <td>
                                                            {{ $office->city->translateOrDefault(locale())->title }}
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    @if( $office->state)
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.state_id')}}
                                                        </td>
                                                        <td>
                                                            {{ $office->state->translateOrDefault(locale())->title }}
                                                        </td>
                                                    </tr>
                                                    @endif


                                                
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{__('user::dashboard.users.datatable.status')}}
                                                        </td>
                                                        <td>
                                                         
                                                            @if ($office->is_active == 1) 
                                                                 <span class="badge badge-success"> {{__('apps::dashboard.datatable.available')}} </span>
                                                                @else
                                                                <span class="badge badge-danger"> {{__('apps::dashboard.datatable.unavailable')}} </span>
                                                              @endif  
                                                           
                                                        </td>
                                                    </tr>


                                                </tbody>
                                                <thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end --}}
                        @endif

                        @php
                            $currentSubscription  = $user->currentSubscription;
                        @endphp

                        @if($user->type == "office" && $user->currentSubscription)
                                                {{-- start --}}
                                                <div class="tab-pane " id="currentSubscription">
                                                    <div class="invoice-content-2 busered">
                                                        <div class="row invoice-head">
                                                           
                                                            <div class="col-md-6 col-xs-6">
                                                                <div class="company-address">
                                                                    <h6 class="uppercase">#{{ $currentSubscription['id'] }}</h6>
                                                                    <h6 class="uppercase">{{date('Y-m-d / H:i:s' , strtotime($currentSubscription->created_at))}}</h6>
                                                                  
                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="row invoice-body" >
                                                                <div class="col-xs-12 table-responsive" style="margin-top: 20px">
                                                                    <table class="table table-bordered ">
                                                                       
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.package_id')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ optional($currentSubscription->package)->title ?? '-----' }}
                                                                                </td>
                                                                            </tr>
                        
                                                                            
                        
                                                                        
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.is_free')}}
                                                                                </td>
                                                                                <td>
                                                                                 
                                                                                    @if ($currentSubscription->is_free == 1) 
                                                                                         <span class="badge badge-success"> {{__('apps::dashboard.datatable.yes')}} </span>
                                                                                        @else
                                                                                        <span class="badge badge-danger"> {{__('apps::dashboard.datatable.no')}} </span>
                                                                                      @endif  
                                                                                   
                                                                                </td>
                                                                            </tr>
                        
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.status')}}
                                                                                </td>
                                                                                <td>
                                                                                   
                                                                                    @if ( $currentSubscription->checkAvailable()) 
                                                                                         <span class="badge badge-success"> {{__('apps::dashboard.datatable.available')}} </span>
                                                                                        @else
                                                                                        <span class="badge badge-danger"> {{__('apps::dashboard.datatable.unavailable')}} </span>
                                                                                      @endif  
                                                                                   
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.start_at')}}
                                                                                </td>
                                                                                <td>
                                                                                 
                                                                                   {{ $currentSubscription->start_at}}
                                                                                   
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.end_at')}}
                                                                                </td>
                                                                                <td>
                                                                                 
                                                                                   {{ $currentSubscription->end_at}}
                                                                                   
                                                                                </td>
                                                                            </tr>
                        
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.current_use')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $currentSubscription->current_use}}
                                                                                  
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.max_use')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $currentSubscription->max_use}}
                                                                                  
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.renewal_at')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $currentSubscription->renewal_at?? "-----"}}
                                                                                  
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.currentSubscription.renewal_count')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $currentSubscription->renewal_count??  0}}
                                                                                  
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            @if($currentSubscription->is_free != 1)
                                                                            <tr>
                                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                                    {{__('user::dashboard.users.datatable.money')}}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $currentSubscription->money}}
                                                                                  
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                            <tr >
                                                                                <td colspan="2"> 
                                                                                    @if($currentSubscription->package)
                                                                                    <form style="display: inline-block" method="POST" action="{{route('dashboard.users.renwal', $user->id)}}">
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-info">{{__('user::dashboard.users.datatable.currentSubscription.renewal')}}</button>
                                                                                    </form>
                                                                                    @endif
                                                                                    <a href="{{route('dashboard.users.edit', $user->id)}}" class="btn btn-sm blue" title="Edit">
                                                                                        <i class="fa fa-edit"></i>
                                                                                      </a>
                                                                                </td>
                                                                            </tr>
                        
                                                                        </tbody>
                                                                        <thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- end --}}
                        @endif

                      

                        
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                    <a href="{{url(route('dashboard.users.index')) }}" class="btn btn-lg red">
                        {{__('apps::dashboard.buttons.back')}}
                    </a>
                </div>
                
            </div>

         

        </div>
    </div>
</div>

@stop

@section('scripts')

  <script>
 
  </script>

@stop
