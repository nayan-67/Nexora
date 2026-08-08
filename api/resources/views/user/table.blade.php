<!--begin::Card Body-->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="fs-7">
                <tr align="center">
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Orders</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fs-7 data-results">
                @if (count($data) > 0)
                    @foreach ($data as $row)
                        @php
                            $name = $row->first_name . ' ' . $row->last_name;
                            $ordresult = DB::table('orders')->where('user_id', $row->id)->get();
                            $profile = $row->profile_image ? 'uploads/' . $row->profile_image : 'avatar.jpg';
                            $date = substr($row->created_at, 0, 10);
                        @endphp
                        <tr align="center">
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset($profile) }}" alt=""
                                        class="img-size-32 rounded-circle me-2" />
                                    <span class="fw-medium">{{ $name ?? 'user' }}</span>
                                </div>
                            </td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ count($ordresult) }}</td>
                            <td>{{ date('M j, Y', strtotime($date)) }}</td>
                            <td>
                                <span
                                    class='list-badge {{ $row->status == '1' ? 'text-bg-success' : 'text-bg-warning' }}'>{{ $row->status == '1' ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('user.view', encrypt($row->id)) }}"
                                        class="btn btn-outline-info d-flex" data-bs-toggle="tooltip"
                                        data-bs-title="View Details">
                                        <i class="bi bi-eye d-flex py-1" aria-hidden="true">
                                        </i>
                                    </a>
                                    {{-- <a href="{{ route('user.order', encrypt($row->id)) }}"
                                        class="btn btn-outline-primary d-flex align-items-center"
                                        data-bs-toggle="tooltip" data-bs-title="Orders">
                                        <i class="bi bi-cart3 d-flex" aria-hidden="true">
                                        </i>
                                    </a> --}}
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="tooltip" data-bs-title="Block User"
                                        onclick="openModal('{{ $row->id }}');">
                                        <i class="bi bi-ban d-flex" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="7">No User Found</td>
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
        @if ($data->total() == 1)
            Showing 1 Customer
        @elseif($data->total() > 1)
            Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }} Customers
        @else
            Showing 0 of 0 Customer
        @endif
    </div>
    <div class="float-end">
        {{ $data->links() }}
    </div>
</div>
<!--end::Card Footer-->
