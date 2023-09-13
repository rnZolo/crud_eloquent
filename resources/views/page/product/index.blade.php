@extends('layouts.app')

@section('head')
    <script src="{{ asset('assets/js/index.js') }}" defer type="text/javascript"></script>
    <title>Product Items</title>
@endsection

@section('content') 
    {{ $req ?? '' }}
    <div class="BS-container">
        <span class="btn bg-green-700 hover:bg-green-400 text-white" id="modal-open-btn">Add Item</span>
        <div class="my-modal hide -translate-y-[80px] h-[110vh] ">
            <form id="store_ajax" 
                class="bg-white shadow-lg min-w-[80%] min-h-fit rounded-box p-5 relative">
                <span class="bi bi-x-circle-fill text-lg absolute top-[-13px] right-[-13px]" id="modal-close-btn"></span>
                <div class="mb-3">
                    <label for="item_number" class="form-label">Item Number</label>
                    <input type="text" class="form-control" id="item_number" name="item_number">
                  </div>
                <div class="mb-3">
                  <label for="item_name" class="form-label">Item Name</label>
                  <input type="text" class="form-control" id="item_name" name="item_name">
                </div>
                <div class="mb-3">
                    <label for="item_price" class="form-label">Item Price</label>
                    <input type="text" class="form-control" id="item_price" name="item_price">
                  </div>
                  <div class="mb-3">
                    <label for="item_category" class="form-label">Item Category</label>
                    <input type="text" class="form-control" id="item_category" name="item_category">
                  </div>
                  <div class="mb-3">
                    <label for="item_stock" class="form-label">Item Stock</label>
                    <input type="number" class="form-control" id="item_stock" name="item_stock">
                  </div>
                <button class="btn bg-blue-700 hover:bg-blue-400 text-white mx-auto" id="submit_ajax">Save Item</button>
              </form>
        </div>
        <table id="item_table" class="table stripe display nowrap" style="width:100%;">
            <thead>
                <tr class="w-full">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Stock</th>
                </tr>
            </tbody>
        </table>
    </div>
@endsection