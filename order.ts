  public async order(payload: { price: string, symbol: string; side: string; type: string; quantity: string }) {

    const timestamp = Date.now();
    const normalizedQueryString = 'order_price='+payload.price+'&order_quantity='+payload.quantity+'&order_type=LIMIT&side='+payload.side+'&symbol=SPOT_BTC_USDT|'+timestamp.toString();

    const params = new URLSearchParams();
    params.append('order_price', payload.price);
    params.append('order_quantity', payload.quantity);
    params.append('order_type', 'LIMIT');
    params.append('side', payload.side);
    params.append('symbol', 'SPOT_BTC_USDT');

    const hmac = crypto.createHmac('sha256', this.apiSecret);
    hmac.update(normalizedQueryString);

    const response = await fetch(this.apiEndpoint+'v1/order', {
      method: 'POST',
      body: params,
      headers: {'Content-Type': 'application/x-www-form-urlencoded',
                'x-api-key': this.apiKey,
                'x-api-signature': hmac.digest('hex'),
                'x-api-timestamp': timestamp.toString(),
                'cache-control': 'no-cache'
               }
    })

    .then( response => response.json() )
    .catch(error => console.log('error', error));

    return response
  }
