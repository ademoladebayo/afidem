function makePayment() {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-4a013176d7cab721b11eef9c4437fbba-X",
      tx_ref: "T1",
      amount: 25000,
      currency: "NGN",
      country: "NG",
      payment_options: " ",
      redirect_url: // specified redirect URL
        "#",
      meta: {
        consumer_id: 23,
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email: "damilolaoyebanji1@gmail.com",
        phone_number: "08102909304",
        name: "Damilola Oyebanji",
      },
      callback: function (data) {
        console.log(data);
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "SSHUB-Payment",
        description: "First term fees",
        logo: "https://assets.piedpiper.com/logo.png",
      },
    });
  }