var a = require('jquery'),
token = a("meta[name='csrf-token']").attr('content'),
body = a('body');

export{ a, token, body };