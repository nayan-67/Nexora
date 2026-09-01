<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>
<body style="font-family: DejaVu Sans, Arial; font-size: 12px; color:#333;">

<!-- TOP BAR -->
<table width="100%" cellspacing="0" cellpadding="10" style="background:#eef5ff; color:#056839;">
    <tr>
        <td>
            <img src="{{ public_path('logo.png') }}" height="40">
        </td>
        <td align="right">
            <h2 style="margin:0;">INVOICE</h2>
        </td>
    </tr>
</table>

<br>

<!-- COMPANY + INVOICE INFO -->
<table width="100%" style="margin-bottom:10px;">
    <tr>
        <td>
            <strong>AgriExpress</strong><br>
            Kolkata, India<br>
            Email: agrins@stagedwebsite.com
        </td>
        <td align="right">
            <strong>Invoice No:</strong> {{ $orderpdf->invoice_number }}<br>
            <strong>Date:</strong> {{ date('d M Y', strtotime($orderpdf->invoice_date)) }}
        </td>
    </tr>
</table>

<hr>

<!-- BILLING + SHIPPING -->
<table width="100%" style="margin-top:10px;">
    <tr>
        <td width="50%">
            <h4 style="margin-bottom:5px;">Billing Address</h4>
            {{ $orderpdf->billing->f_name }} {{ $orderpdf->billing->l_name }}<br>
            {{ $orderpdf->billing->address1 }}<br>
            {{ $orderpdf->billing->city ?? '' }}<br>
            {{ $orderpdf->billing->country ?? '' }}
        </td>

        <td width="50%">
            <h4 style="margin-bottom:5px;">Shipping Address</h4>
            {{ $orderpdf->shipping->f_name ?? '' }} {{ $orderpdf->shipping->l_name ?? '' }}<br>
            {{ $orderpdf->shipping->address1 ?? '' }}<br>
            {{ $orderpdf->shipping->city ?? '' }}<br>
            {{ $orderpdf->shipping->country ?? '' }}
        </td>
    </tr>
</table>

<br>

<!-- orderpdf INFO -->
<table width="100%" style="margin-bottom:10px;">
    <tr>
        <td>
            <strong>Order ID:</strong> #OD-0{{ $orderpdf->id }}<br>
            <strong>Payment:</strong> {{ ucfirst($orderpdf->payment_mode) }}
        </td>
        <td align="right">
            <strong>Status:</strong> {{ $orderpdf->payment_status }}
        </td>
    </tr>
</table>

<!-- PRODUCT TABLE -->
<table width="100%" borderpdf="1" cellspacing="0" cellpadding="8">
    <thead>
        <tr style="background:#f2f2f2;">
            <th align="left">Product</th>
            <th align="center">Qty</th>
            <th align="right">Price</th>
            <th align="right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orderpdf->items as $item)
        <tr>
            <td>{{ $item->product->name ?? 'Product' }}</td>
            <td align="center">{{ $item->quantity }}</td>
            <td align="right">${{ number_format($item->price, 2) }}</td>
            <td align="right">${{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<!-- SUMMARY BOX -->
<table width="100%">
    <tr>
        <td width="60%"></td>
        <td width="40%">
            <table width="100%" cellpadding="5">
                <tr>
                    <td>Subtotal</td>
                    <td align="right">${{ number_format($orderpdf->total_price - $orderpdf->eco_tax - $orderpdf->vat + $orderpdf->discount, 2) }}</td>
                </tr>
                <tr>
                    <td>Eco Tax</td>
                    <td align="right">${{ number_format($orderpdf->eco_tax, 2) }}</td>
                </tr>
                <tr>
                    <td>VAT</td>
                    <td align="right">${{ number_format($orderpdf->vat, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td align="right">- ${{ number_format($orderpdf->discount, 2) }}</td>
                </tr>
                <tr style="background:#f2f2f2;">
                    <td><strong>Total</strong></td>
                    <td align="right"><strong>${{ number_format($orderpdf->total_price, 2) }}</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br>

<!-- FOOTER -->
<hr>

<p style="text-align:center; font-size:11px;">
    Thank you for shopping with us ❤️<br>
    This is a computer-generated invoice.
</p>

</body>
</html>