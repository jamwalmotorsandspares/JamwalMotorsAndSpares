let previousNotificationCount =
    parseInt($('#notification-count').text()) || 0;
var baseUrl = window.location.origin +"/"+ window.location.pathname.split('/')[1] +"/"+ window.location.pathname.split('/')[2] +"/"+window.location.pathname.split('/')[3]+"/"+window.location.pathname.split('/')[4];
var url = baseUrl + "/notifications/latest";
function loadNotifications() {

    $.ajax({
        url: url,
        type: "GET",

        success: function(response) {

            $('#notification-count').text(response.count);

            if (response.count > previousNotificationCount) {

                // Ring bell
               $('.notification-bell').addClass('ringing');

                setTimeout(function () {
                    $('.notification-bell')
                        .removeClass('ringing');
                }, 1000);

                // Play sound
                let sound = document.getElementById(
                    'notificationSound'
                );

                if (sound) {

                    sound.currentTime = 0;

                    sound.play().catch(function(error) {
                        console.log(
                            'Browser blocked notification sound',
                            error
                        );
                    });
                }

                // Reload notification list
                updateNotificationList(response.notifications);
            }

            previousNotificationCount = response.count;
        }
    });
}
function updateNotificationList(notifications) {

    let html = '';

    if (notifications.length === 0) {

        html = `
            <div class="dropdown-item text-center">
                No notifications
            </div>
        `;

    } else {

        notifications.forEach(function(notification) {

            html += `
                <a href="${notification.url}"
                   class="dropdown-item notification-item
                   ${notification.read ? '' : 'unread'}"
                   data-id="${notification.id}">

                    <div>
                        <strong>
                            ${notification.title}
                        </strong>
                    </div>

                    <small>
                        ${notification.message}
                    </small>

                    <br>

                    <small class="text-muted">
                        ${notification.time}
                    </small>

                </a>
            `;
        });
    }

    $('#notification-list').html(html);
}


