@extends('layouts.app')

@section('links')
@endsection

@section('notif')
    @if (session('store'))
        <span class="txt-lg font-bold text-black">{{ session('store') }}</span>
    @endif
@endsection

@section('content')
    {{ session('status') }}
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div id="whole" class="w-full h-full px-[5%] pb-[100px] relative">
        <div class="my-modal hide -translate-y-[15%] h-[110vh] absolute z-10 min-w-[100%] top-0 left-0">
            <form id="store_ajax" class="bg-white w-[80%] p-5 shadow-lg flex flex-col rounded-box relative">
                    @include('inc.form')
            </form>
        </div>
        <div class="overflow-hidden border-1 border-slate-500 rounded-box  p-3 shadow-md">
            <div class="commands flex gap-8">
                <a
                    class="btn bg-green-700 hover:bg-green-400 m-2 text-white i bi-person-fill-add " id="modal-open-btn">
                    Add Students
                </a>
                <form class="flex justify-center items-center min-w-[50px] ">
                    <label for="filter_by" class="" id="test-btn">Filter By :
                        <select name="filter_by" id="filter_by" class="filterby">
                            <option value="all">All</option>
                            <option value="local_only">Local</option>
                            <option value="foreign_only">Foreign</option>
                        </select>
                    </label>
                </form>
                <label for="select_all" class="ml-auto flex justify-center items-center">Select All: <span  id="select_all" class="ml-5"></span></label>
                <button class=" bg-red-700 hover:bg-red-800 text-white p-2 bi bi-trash3-fill flex justify-center items-center " 
                id="multi_del" disabled >Mulitple Delete</button>
            </div>
            <div class="w-full">
                <table class="table display nowrap" id="index_table" style="width:100%;">
                    <!-- head -->
                    <thead class="bg-neutral-700 text-white">
                        <tr>
                            {{-- <th></th> --}}
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>  
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                            {{-- <td></td> --}}
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection
