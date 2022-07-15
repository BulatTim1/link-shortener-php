
document.addEventListener('DOMContentLoaded', () => {
    let form = document.getElementsByTagName('form')[0];
    let inp = form.getElementsByTagName('input')[0];
    let btn = form.getElementsByTagName('button')[0];
    let link = document.getElementById('link');

    console.log(form, inp, btn, link);

    let getLink = (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('url', inp.value);

        fetch('make-link.php', {
            method: 'POST',
            body: data
        }).then(r => r.text())
            .then(text => {
                link.innerHTML = location.origin + '/?u=' + text;
                link.href = location.origin + '/?u=' + text;
            });
    };

    form.addEventListener('submit', getLink);
});
