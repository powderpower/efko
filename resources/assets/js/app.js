import '../scss/app.scss';
import  { a, token, body } from './components/config';

(function()
{
    var location = window.location.pathname,
    postData = {'_token': token},
    errorMessage = 'Woops, something went wrong';

    body.on('page:normalize', () =>
    {
        var parametres = [];

        a('.card').each(function()
        {
            var height = a(this).find('.card-text').height();
            parametres.push(height);
        })
        
        a('.card-text').css('height', Math.max.apply(null, parametres));
        a('.card').removeClass('op-null');
    });

    body.on('click:index', () =>
    {
        body.on('click', '.clickable', function()
        {
            var b = a(this),
            c = b.attr('id');
            a.post('/auth/login/' + c, postData, 'json')
            .done((d) =>
            {
                d.stat ? document.location.reload() : alert(errorMessage);
            })
            .fail(() =>
            {
                alert(errorMessage);
            });
        });
    });

    body.on('click:manage', () =>
    {
        body.on('click', '.clickable', function()
        {
            var b = a(this),
            c = b.attr('opt'),
            request = {};
            postData = {'_token': token};

            switch(c)
            {
                case 'logout':
                    request.link = '/auth/logout';
                    request.result = 'logged_out';
                    break;
                case 'ask-vacation':
                    postData.leave = a('input#ask-vacation-leave').val();
                    postData.back = a('input#ask-vacation-back').val();
                    request.link = '/manage/vacation';
                    request.result = 'requested';
                    break;
                case 'accept':
                    postData.action = 'accept';
                    postData.user = b.attr('id');
                    request.link = '/manage/update';
                    request.result = 'accepted';
                    break;
                case 'refuse':
                    postData.action = 'refuse';
                    postData.user = b.attr('id');
                    request.link = '/manage/update';
                    request.result = 'refused';
                    break;
                case 'clear':
                    postData.action = 'clear';
                    request.link = '/manage/update';
                    request.result = 'cleared';
                    break;
                default:
                    alert('action is not defined');
                    break;
            }

            (Object.keys(request).length)&&
            (a.post(request.link, postData, 'json')
            .done((d) => { d.stat == request.result ? document.location.reload() : alert(d.stat || errorMessage)})
            .fail(() => { alert(errorMessage) }));
        });        
    });

    switch(location)
    {
        case '/manage':
            body.trigger('click:manage');
            break;
        default :
            body.trigger('page:normalize');
            body.trigger('click:index');
            break;
    }

})();