document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".woof-section-9-main-row-col-2-row-1");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        fetch("sendMail.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Message Sent Successfully!",
                    text: "Thank you! We will get back to you soon.",
                    showConfirmButton: false,
                    timer: 2000
                });

                form.reset(); // Clear the form fields after successful submission
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error Sending Message",
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Something went wrong!",
                text: "Please try again later."
            });
        });
    });
});





const slider = document.querySelector('.woof-sec11-track');
const items = document.querySelectorAll('.woof-sec11-track .col-md-4');
const totalItems = items.length;
const clonedItems = 3; // Number of cloned items at the end

// Clone first `clonedItems` items and append them to the end
for (let i = 0; i < clonedItems; i++) {
    const clone = items[i].cloneNode(true);
    slider.appendChild(clone);
}

let index = 0;
const slideWidth = 33.33; // Width of each slide

function moveSlider() {
    index++;
    slider.style.transition = 'transform 0.5s ease-in-out';
    slider.style.transform = `translateX(${-index * slideWidth}%)`;

    // When reaching cloned slides, instantly reset without user noticing
    if (index === totalItems) {
        setTimeout(() => {
            slider.style.transition = 'none';
            index = 0;
            slider.style.transform = `translateX(0%)`;
        }, 500); // Wait for transition to end before resetting
    }
}

// Auto-scroll every 1.5 seconds
setInterval(moveSlider, 1500);
