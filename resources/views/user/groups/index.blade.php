@extends('layouts.main') @section('content')
<?php usort($tableGrid, "SiteHelpers::_sort") ?>
    <div class="page-content">

        @include('layouts.breadcrumb')

        <div class="portlet light bordered page-content-wrapper">
            <ul class="nav nav-tabs" style="margin-bottom:10px;">
                <li><a href="{{ URL::to('user')}}"><i class="fa fa-user"></i> Users </a></li>
                <li class="active"><a href="{{ URL::to('user/groups')}}"><i class="fa fa-users"></i> Groups</a></li>
                <li class=""><a href="{{ URL::to('user/blast')}}"><i class="fa fa-envelope"></i> Send Email </a></li>
            </ul>

            <div class="portlet light bordered animated fadeInUp">
                <div class="portlet-title">
                    @if(isset($pageTitle) && isset($pageNote))
                    <div class="caption">
                        <i class="icon-social-dribbble font-blue-sharp"></i>
                        <span class="caption-subject font-blue-sharp bold uppercase">{{ $pageTitle }} : <small> {{ $pageNote }}</small></span>
                    </div>
                    @endif
                    <div class="actions">
                        @if($access['is_add'] ==1)
                        <a href="{{ URL::to('user/groups/update') }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_create') }}">
                            <i class="fa  fa-plus"></i></a>
                        @endif @if($access['is_remove'] ==1)
                        <a href="javascript://ajax" onclick="SximoDelete();" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_remove') }}">
                            <i class="fa fa-trash-o"></i></a>
                        @endif @if($access['is_excel'] ==1)
                        <a href="{{ URL::to('user/groups/download') }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_download') }}">
                            <i class="fa fa-cloud-download"></i></a>
                        @endif
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::open(array('url'=>'user/groups/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
                    <div class="table-responsive" style="min-height:300px;">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th class="number"> No </th>
                                    <th>
                                        <input type="checkbox" class="checkall" />
                                    </th>

                                    @foreach ($tableGrid as $t) @if($t['view'] =='1')
                                    <th>{{ $t['label'] }}</th>
                                    @endif @endforeach
                                    <th width="70">{{ Lang::get('core.btn_action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($rowData as $row)
                                <tr>
                                    <td width="30"> {{ ++$i }} </td>
                                    <td width="50">
                                        <input type="checkbox" class="ids" name="id[]" value="{{ $row->group_id }}" /> </td>
                                    @foreach ($tableGrid as $field) @if($field['view'] =='1')
                                    <td>
                                        @if($field['attribute']['image']['active'] =='1') {{ SiteHelpers::showUploadedFile($row->$field['field'],$field['attribute']['image']['path']) }} @else
                                        <?php $conn = (isset($field['conn']) ? $field['conn'] : array() ) ?>
                                            {!! SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) !!} @endif
                                    </td>
                                    @endif @endforeach
                                    <td>
                                        @if($access['is_detail'] ==1)
                                        <a href="{{ URL::to('user/groups/show/'.$row->group_id.'?return='.$return)}}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i></a> @endif @if($access['is_edit'] ==1)
                                        <a href="{{ URL::to('user/groups/update/'.$row->group_id.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a> @endif

                                    </td>
                                </tr>

                                @endforeach

                            </tbody>

                        </table>
                        <input type="hidden" name="md" value="" />
                    </div>
                    {!! Form::close() !!} @include('footer')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.do-quick-search').click(function() {
                $('#SximoTable').attr('action', '{{ URL::to("cpre/groups/multisearch")}}');
                $('#SximoTable').submit();
            });

        });
    </script>
    @stop