/**
 author: TiMi
 anh em có xài thì giữ nguyên tên tác giả là TiMi nhé, cảm ơn anh em :333
 */

Notiflix.Report.init({
    backOverlayClickToClose: !0,
    svgSize: "50px",
    cssAnimationDuration: 100,
    backgroundColor: "#043a34",
    success: {
        backOverlayColor: "rgb(93 93 93 / 20%)",
        titleColor: "#fff",
        messageColor: "#fff"
    },
    failure: {
        backOverlayColor: "rgb(93 93 93 / 20%)",
        titleColor: "#fff",
        messageColor: "#fff"
    },
    warning: {
        backOverlayColor: "rgb(93 93 93 / 20%)",
        titleColor: "#fff",
        messageColor: "#fff"
    },
    info: { backOverlayColor: "rgb(93 93 93 / 20%)", titleColor: "#fff", messageColor: "#fff" }
});

document.addEventListener('DOMContentLoaded', function () {
    // Hàm tạo vị trí ngẫu nhiên
    function getRandomPosition(current) {
        let x, y, distance;
        do {
            x = Math.floor(-33 * Math.random());
            y = Math.floor(-33 * Math.random());
            distance = Math.sqrt(Math.pow(x - current.x, 2) + Math.pow(y - current.y, 2));
        } while (distance > 25 || distance < 20);
        return { x, y };
    }

    // Chọn phần tử background
    const background = document.querySelector('.background');

    // Giá trị hiện tại của vị trí
    let currentPosition = { x: 0, y: 0 };

    // Hàm cập nhật vị trí
    function updatePosition() {
        currentPosition = getRandomPosition(currentPosition);
        background.style.transform = `translate(${currentPosition.x}%, ${currentPosition.y}%)`;
    }

    // Thiết lập để cập nhật vị trí mỗi 5 giây
    setInterval(updatePosition, 5000);

    // Cập nhật vị trí ngay lập tức sau khi 50ms
    setTimeout(updatePosition, 50);



    const helloContainer = document.getElementById('hello-container');
    const mainContainer = document.getElementById('container');
    let countdown = 3;
    let isButtonVisible = false;

    function startCountdown(setShowHello) {
        isButtonVisible = true;
        renderHello(setShowHello);

        const interval = setInterval(() => {
            countdown--;
            if (countdown < 0) {
                clearInterval(interval);
                setShowHello(false);
                renderHello(setShowHello);
            } else {
                renderHello(setShowHello);
            }
        }, 1000);
    }

    function renderHello(setShowHello) {
        helloContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center min-vh-100 container">
        <div class="text-center p-3 w-100 main-border card" style="background: rgb(4, 58, 52);">
            <div class="card-body">
                <div class="Typewriter" data-testid="typewriter-wrapper"><span id="typed-text" class="fw-semibold fs-6"></span><span
                            class="Typewriter__cursor"></span></div>
                            ${isButtonVisible ? `<button class="btn btn-success mt-3" onclick="hideHello()">Trang chủ (${countdown})</button>` : ''}
            </div>
        </div>
    </div>`;
        if (!isButtonVisible) {
            const typed = new Typed('#typed-text', {
                strings: [
                    "Xin chào Mọi Người!",
                    "Chào mừng tới với trang web của Doãn Công Sinh"
                ],
                typeSpeed: 30,
                backSpeed: 30,
                loop: false,
                onComplete: function () {
                    startCountdown(setShowHello);
                }
            });
        } else {
            document.getElementById('typed-text').innerText = "Chào mừng tới với trang web của Doãn Công Sinh";
        }
    }

    window.hideHello = function () {
        setShowHello(false);
    };

    function setShowHello(show) {
        if (show) {
            renderHello(setShowHello);
        } else {
            helloContainer.classList.add('d-none');
            mainContainer.classList.remove('d-none');
            $('#serverModal').modal('show');
        }
    }


    function checkLastSeen() {
        const lastSeen = parseInt(localStorage.getItem("lastSeenHello") || "0", 10);
        if (!lastSeen || Date.now() - lastSeen > 432000000) {
            localStorage.setItem("lastSeenHello", Date.now().toString());
            setShowHello(true);
        } else {
            setShowHello(false);
        }
    }

    checkLastSeen();

});

$(document).ready(function () {
    const collection = document.getElementsByClassName('timi-form');
    if (collection) {
        for (let i = 0; i < collection.length; i++) {
            let TiMi_Form = collection[i];

            TiMi_Form.addEventListener('submit', function (event) {
                event.preventDefault();

                const _this = $(this);
                const button_submit = _this.find('button[type="submit"]');
                const preContent = button_submit.html();
                button_submit.html(`Đang xử lý...`).prop('disabled', true);

                // Gửi dữ liệu form bằng AJAX
                fetch(TiMi_Form.action, {
                    // method: TiMi_Form.method,
                    method: 'POST',
                    body: new FormData(TiMi_Form)
                })
                    .then(response => response.json())
                    .then(data => {
                        // Xử lý phản hồi từ máy chủ
                        const div_alert_mess = _this.find('div.alert-mess');
                        if (div_alert_mess.length < 1) {
                            if (data.success) {
                                Notiflix.Report.success('Thành công', data.message, "Xác nhận");
                                setTimeout(() => window.location.reload(), 1000)
                            } else {
                                Notiflix.Report.failure('Thất bại', data.message, "Xác nhận");
                            }
                        } else {
                            div_alert_mess.html(`<div class="alert alert-${data.success ? 'success' : 'danger'}">${data.message}</div>`);
                            data.success && !_this.attr('reload') && setTimeout(() => window.location.reload(), 500);
                        }
                    })
                    .catch(error => {
                        // Xử lý lỗi nếu có
                        Notiflix.Report.failure('Thất bại', "Có lỗi xảy ra, hãy thử lại", "Xác nhận");
                    })
                    .finally(() => {
                        button_submit.html(preContent).prop('disabled', false);
                    });
            });
        }
    }
});