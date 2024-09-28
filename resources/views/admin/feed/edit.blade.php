@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Feed</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.feed.show') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.feed.update', $feeds->id) }}" enctype='multipart/form-data'>
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="vendor">Vendor</label> <span class="text-danger">*</span>
                                        <select id="vendor_id" name="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror">
                                            <option value="">Select Vendor</option>
                                            @php
                                                $currentVendorId = $feeds->vendor_id;
                                            @endphp
                                            @if(!empty($vendors))
                                                @foreach($vendors as $key => $vendor)
                                                    <option value="{{ $vendor->id }}"
                                                        {{ (old('vendor', $currentVendorId) == $vendor->id) ? 'selected' : '' }}>
                                                        {{ $vendor->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">There are no vendor available</option>
                                            @endif
                                        </select>
                                        @error('vendor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name"  value="{{ old('name', $feeds->name) }}" id="name" class="form-control" placeholder="Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="function_name">Function Name<span class="text-danger">*</span></label>
                                    <input type="text" name="function_name"  value="{{old('function_name', $feeds->function_name)}}" id="function_name" class="form-control" placeholder="Function Name">
                                    @error('function_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Type<span class="text-danger">*</span></label>
                                    <input type="text" name="type"  value="{{old('type', $feeds->type)}}" id="type" class="form-control" placeholder="Function Name">
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="header_perameter" class="col-form-label">Header Perameters</label>
                                    <div class="">
                                        <table class="table" id="header_field">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($feeds->header_parameter))
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ( $feeds->header_parameter as $k=>$head)
                                                        <tr>
                                                            <td>
                                                                <h4>{{ $i }}</h4>
                                                            </td>
                                                            <td>
                                                                <select id="attribute_id" name="header_attribute_id[]" class="form-control @error('attribute_id') is-invalid @enderror">
                                                                    <option value="">Select Attribute</option>
                                                                    @php
                                                                        $currentAttrId = $head['key'];
                                                                    @endphp
                                                                    @if(!empty($attributes))
                                                                        @foreach($attributes as $key => $attribute)
                                                                            <option value="{{ $attribute->id }}" {{ (old('vendor', $currentAttrId) == $attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                                        @endforeach
                                                                        @else
                                                                    <option value="">There are no attribute available</option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="header_attribute_value[]" value="{{ $head['value'] }}" class="form-control">
                                                            </td>

                                                            <td>
                                                                @if ($i == 1)
                                                                    <button type="button" name="add" id="addHeader" class="btn btn-success">Add More</button>
                                                                @else
                                                                    <button type="button" name="remove" id="{{ $k }}" class="btn btn-danger btn_remove">X</button>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            <h4>1</h4>
                                                        </td>
                                                        <td>
                                                            <select id="attribute_id" name="header_attribute_id[]" class="form-control @error('attribute_id') is-invalid @enderror">
                                                                <option value="">Select Attribute</option>
                                                                @if(!empty($attributes))
                                                                    @foreach($attributes as $key => $attribute)
                                                                        <option value="{{ $attribute->id }}" {{ (old('attribute') == $attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                                    @endforeach
                                                                    @else
                                                                <option value="">There are no attribute available</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="header_attribute_value[]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <button type="button" name="add" id="addHeader" class="btn btn-success">Add More</button>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="body_perameter" class="col-form-label">Body Perameters</label>
                                    <div class="">
                                        <table class="table" id="body_field">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($feeds->body_parameter))
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ( $feeds->body_parameter as $body)
                                                    <tr>
                                                        <td>
                                                            <h4>{{ $i }}</h4>
                                                        </td>
                                                        <td>
                                                            <select id="attribute_id" name="body_attribute_id[]" class="form-control @error('attribute_id') is-invalid @enderror">
                                                                <option value="">Select Attribute</option>
                                                                @php
                                                                    $currentAttrId = $body['key'];
                                                                @endphp
                                                                @if(!empty($attributes))
                                                                    @foreach($attributes as $key => $attribute)
                                                                        <option value="{{ $attribute->id }}" {{ (old('attribute', $currentAttrId) == $attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                <option value="">There are no attribute available</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="body_attribute_value[]" value="{{ $body['value'] }}" class="form-control">
                                                        </td>
                                                        <td>
                                                            @if ($i == 1)
                                                            <button type="button" name="add" id="addBody" class="btn btn-success">Add More</button>
                                                            @else
                                                                <button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <h4>1</h4>
                                                </td>
                                                <td>
                                                    <select id="attribute_id" name="body_attribute_id[]" class="form-control @error('attribute_id') is-invalid @enderror">
                                                        <option value="">Select Attribute</option>
                                                        @if(!empty($attributes))
                                                            @foreach($attributes as $key => $attribute)
                                                                <option value="{{ $attribute->id }}" {{ (old('attribute') == $attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                            @endforeach
                                                        @else
                                                        <option value="">There are no attribute available</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="body_attribute_value[]" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" name="add" id="addBody" class="btn btn-success">Add More</button>
                                                </td>
                                            </tr>
                                        @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?php echo $attribute->status == 1 ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $attribute->status == 0 ? 'selected' : ''; ?>>Block</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('admin.feed.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @php
    $attrHtml = '';
    $attrHtml .= '<option value="">Select Attribute</option>';
    if (!empty($attributes)) {
        foreach ($attributes as $attribute) {
            $selected = (old('attribute') == $attribute->id) ? 'selected' : '';
            $attrHtml .= '<option value="' . htmlspecialchars($attribute->id) . '" ' . $selected . '>' . htmlspecialchars($attribute->name) . '</option>';
        }
    } else {
        $attrHtml .= '<option value="">There are no attributes available</option>';
    }
    $attrHtmlJs = json_encode($attrHtml);
@endphp
@endsection
@push('styles')
@endpush
@section('scripts')

<script>
    var i = 1;
    $('#addHeader').click(function() {
        var attrHtml = JSON.parse(@json($attrHtmlJs));
        i++;
        $('#header_field').append(
            '<tr id="row_header' + i + '">'
            +'<td><h4>' + i + '</h4></td>'
            +'<td><select id="attribute_id" name="header_attribute_id[]" class="form-control">' + attrHtml + '</select></td>'
            +'<td><input type="text" name="header_attribute_value[]" class="form-control"></td>'
            +'<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td>'
            +'</tr>'
        );
    });
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row_header' + button_id).remove();
    });
</script>

<script>
    var i = 1;
    $('#addBody').click(function() {
        var attrHtml = JSON.parse(@json($attrHtmlJs));
        i++;
        $('#body_field').append(
            '<tr id="row_body' + i + '">'
            +'<td><h4>' + i + '</h4></td>'
            +'<td><select id="attribute_id" name="body_attribute_id[]" class="form-control">' + attrHtml + '</select></td>'
            +'<td><input type="text" name="body_attribute_value[]" class="form-control"></td>'
            +'<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td>'
            +'</tr>'
        );
    });
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row_body' + button_id).remove();
    });
</script>

@endsection
