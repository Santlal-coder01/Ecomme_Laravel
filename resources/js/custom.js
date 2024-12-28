document.querySelector("#add-to-wishlist").addEventListener("click", function () {
    const productId = this.dataset.productId;

    fetch("/wishlist/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ product_id: productId }),
    })
    .then((response) => response.json())
    .then((data) => {
        alert(data.message);
    })
    .catch((error) => console.error("Error:", error));
});
