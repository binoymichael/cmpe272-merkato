<p>Hello {{$user->name}}, </p>
<p>This is confirmation of the recent order you placed with us.</p>
<p>You can track the order status at {{ url('/orders/' . $order->id) }}</p>
<p>Thanks,<br/> Team Merkato</p>

