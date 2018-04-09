var withoutReaction = document.getElementById('withoutReaction');
withoutReaction.addEventListener('change', function (event) {
    var agility = document.getElementById('agility');
    if (this.checked) {
        disableInputs([agility]);
    } else {
        enableInputs([agility]);
    }
    if (!event.bubbles) {
        event.stopPropagation();
    }
});

function disableInputs(inputs) {
    for (var inputsLength = inputs.length, index = 0; index < inputsLength; index++) {
        inputs[index].disabled = 'disabled';
        inputs[index].className += ' disabled';
    }
}

function enableInputs(inputs) {
    for (var inputsLength = inputs.length, index = 0; index < inputsLength; index++) {
        inputs[index].disabled = false;
        inputs[index].className = inputs[index].className.replace('disabled', '');
    }
}

var onHorseback = document.getElementById('onHorseback');
onHorseback.addEventListener('change', function (event) {
    var horseRelated = document.getElementsByClassName('horseRelated');
    if (this.checked) {
        enableInputs(horseRelated);
    } else {
        disableInputs(horseRelated);
    }
    if (!event.bubbles) {
        event.stopPropagation();
    }
});

var changeEvent = new Event('change');
changeEvent.initEvent('change', false /* can not bubble */, true);
withoutReaction.dispatchEvent(changeEvent);
onHorseback.dispatchEvent(changeEvent);