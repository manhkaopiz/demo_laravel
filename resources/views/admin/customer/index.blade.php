<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <script>
        function confirmAction(event, message) {
            if (!confirm(message)) {
                event.preventDefault(); // Ngăn không cho form được gửi nếu người dùng chọn "Hủy"
            }
        }
    </script>
</head>
<body>
<h1>Manage Customers</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->is_approved ? 'Approved' : 'Pending' }}</td>
            <td>
                @if (!$customer->is_approved)
                    <form action="{{ route('admin.customers.approve', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" onclick="confirmAction(event, 'Bạn chắc chắn muốn xác nhận khách hàng?')">Approve</button>
                    </form>
                @else
                    <form action="{{ route('admin.customers.disapprove', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" onclick="confirmAction(event, 'Bạn có muốn hủy khách hàng?')">Disapprove</button>
                    </form>
                @endif

                <form action="{{ route('admin.customers.delete', $customer->id) }}" method="POST" style="display:inline;" onsubmit="confirmAction(event, 'Are you sure you want to delete this customer?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
