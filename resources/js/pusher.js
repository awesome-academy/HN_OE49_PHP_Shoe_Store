$(document).ready(function(){
    function trans(key, replace = {}) {
        let translation = window.translationJsons[key] || key;
      
        for (var placeholder in replace) {
          translation = translation.replace(`:${placeholder}`, replace[placeholder]);
        }
      
        return translation;
    }

    var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
        encrypted: true,
        cluster: "ap1",
    });
    
    var channel = pusher.subscribe("NotificationEvent");
    channel.bind("send-notification", async function (data) {
        console.log(data)
        let pending = parseInt($("#notifications").find(".pending").html());
        if (Number.isNaN(pending)) {
            $("#notifications").append(
                '<span class="pending badge bg-primary badge-number">1</span>'
            );
        } else {
            $("#notifications")
                .find(".pending")
                .html(pending + 1);
        }
        let url = window.location.protocol + '//' + window.location.host + 'mark-at-read/' + data.order_id + '/' + data.id;

        let notificationItem = `
        <li data-id="{{ $notification->id }}"
            class="notification-item unread">
            <a class="text-decoration-none" href="` + url + `">
                <p class="mb-1">${ trans(data.title) }</p>
                <small>${ trans(data.content) }</small>
            </a>
        </li>`;
        $("#notification-list").prepend(notificationItem);
    });
})
