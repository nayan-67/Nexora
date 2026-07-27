<!--begin::Card Body-->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="fs-7">
                <tr align="center">
                    <th>Coupon</th>
                    <th>Valid From</th>
                    <th>Valid Till</th>
                    <th>Amount</th>
                    <th>Coupon Used</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fs-7 data-results">
                @if (count($data) > 0)
                    @foreach ($data as $row)
                        @php
                            $date = substr($row->created_at, 0, 10);
                        @endphp
                        <tr align="center">
                            <td>{{ $row->name }}</td>
                            <td>{{ date('M j, Y', strtotime($row->valid_from)) }}</td>
                            <td>{{ $row->valid_till ? date('M j, Y', strtotime($row->valid_till)) : 'Not Set' }}
                            </td>
                            <td>{{ $row->type == '1' ? $row->amount . ' %' : '₹ ' . $row->amount }}
                            </td>
                            <td>{{ $row->uses_number }}</td>
                            <td>
                                <span
                                    class='list-badge {{ $row->status == '1' ? 'text-bg-success' : 'text-bg-warning' }}'>{{ $row->status == '1' ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>{{ date('M j, Y', strtotime($date)) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('coupon.edit', encrypt($row->id)) }}" class="btn btn-outline-info"
                                        data-bs-toggle="tooltip" data-bs-title="Edit">
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
                        <td colspan="8">No Coupon Found</td>
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
    <div class="float-start pt-1 fs-7 text-body-secondary">
        @if ($data->total() > 0)
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} Coupon
        @else
            Showing 0 of 0 Coupon
        @endif
    </div>
    <div class="float-end">
        {{ $data->links() }}
    </div>
</div>
<!--end::Card Footer-->
