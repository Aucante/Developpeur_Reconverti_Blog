window.onload = () => {
    const FiltersForm = document.querySelector("#filters");
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            // Collect form data
            const Form = new FormData(FiltersForm);

            const Params = new URLSearchParams();
            Form.forEach((value, key) => {
                Params.append(key, value);
            })

            const Url = new URL(window.location.href);

            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response =>
                response.json()
            ).then(data => {
                const Content = document.querySelector("#blogposts");
                Content.innerHTML = data.content;
            }).catch(e => alert(e));
        });
    });
}