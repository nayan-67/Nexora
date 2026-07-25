<!--begin::Card Body-->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="fs-7">
                <tr align="center">
                    <th>Sub Category</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fs-7 data-results">
                @if (count($data) > 0)
                    @foreach ($data as $row)
                        @php
                            $cat = DB::table('category')->where('id', $row->category_id)->first();
                            $date = substr($row->created_at, 0, 10);
                        @endphp
                        <tr align="center">
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->slug }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ date('M j, Y', strtotime($date)) }}</td>
                            <td>
                                <div class="form-check form-switch mb-0" style="width: fit-content;margin-left:9px;"
                                    title="{{ $row->status == '1' ? 'Active' : 'Inactive' }}">
                                    <input class="form-check-input subcat-st" type="checkbox" role="switch"
                                        id="{{ $row->id }}" {{ $row->status == '1' ? 'checked' : '' }} />
                                    <label class="visually-hidden" for="{{ $row->id }}">
                                        Toggle Sub Category status
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('subcategory.edit', encrypt($row->id)) }}"
                                        style="margin-right: 1px;" class="btn btn-outline-info" data-bs-toggle="tooltip"
                                        data-bs-title="Edit">
                                        <i class="bi bi-pencil d-flex" aria-hidden="true"> </i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip"
                                        data-bs-title="Delete" onclick="openModal('{{ $row->id }}');">
                                        <i class="bi bi-trash d-flex" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="7">No Sub Category Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->
</div>
<!--end::Card Body-->
<!--begin::Card Footer-->
<div class="card-footer clearfix">
    {{ $data->links() }}
</div>
<!--end::Card Footer-->
