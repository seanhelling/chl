function verifyUrl(url) {
    try {
        new URL(url)
        return true;
    } catch (err) {
        console.warn(err)
        return false;
    }
}

function processShortenRequest(event) {
    var urlBox = document.querySelector('#urlInput')
    var urlInput = document.querySelector('#urlInput').value
    clearAllProblemBoxes()
    if (verifyUrl(urlInput)) {
        markValid(urlBox)
        console.log(urlInput)
    }
    else {
        event.preventDefault()
        console.warn('Invalid url ' + urlInput)
        markInvalid(urlBox)
        urlBox.value = ''
    }
}

function markInvalid(el, reason = undefined) {
    unmarkBox(el)
    el.classList.add('is-invalid')
    if (reason !== undefined) {
        let problemDescriptionBox = document.createElement("div");
        problemDescriptionBox.id = "problemBox"
        problemDescriptionBox.classList.add('text-danger', 'text-end')
        problemDescriptionBox.textContent = reason
        el.after(problemDescriptionBox)
    }
}

function markValid(el, reason = undefined) {
    unmarkBox(el)
    el.classList.add('is-valid')
    if (reason !== undefined) {
        let problemDescriptionBox = document.createElement("div");
        problemDescriptionBox.id = "problemBox"
        problemDescriptionBox.classList.add('text-success', 'text-end')
        problemDescriptionBox.textContent = reason
        el.after(problemDescriptionBox)
    }
}

function unmarkBox(el) {
    el.classList.remove('is-invalid')
    el.classList.remove('is-valid')
}

function clearAllProblemBoxes() {
    if (document.contains(document.querySelector('#problemBox'))) {
        document.querySelector('#problemBox').remove()
    }
}

document.querySelector('form').addEventListener('submit', processShortenRequest, false)
