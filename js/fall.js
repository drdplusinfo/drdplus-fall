document.addEventListener('DOMContentLoaded', function () {
    var withoutReaction = document.getElementById('without_reaction');
    withoutReaction.addEventListener('change', () => toggleAgilityInput(this));
    toggleAgilityInput(withoutReaction);

    function toggleAgilityInput(input) {
        var agility = document.getElementById('agility');
        if (input.checked) {
            disableInputs([agility]);
        } else {
            enableInputs([agility]);
        }
    }

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

    var fallingFromHeight = document.getElementById('falling_from_height');
    fallingFromHeight.addEventListener('change', () => toggleHeightRelated(this));
    toggleHeightRelated(fallingFromHeight);

    function toggleHeightRelated(input) {
        var heightRelated = document.getElementsByClassName('height-related');
        if (!input.checked) {
            disableInputs(heightRelated);
        } else {
            enableInputs(heightRelated);
        }
    }

    var onHorseback = document.getElementById('on_horseback');
    onHorseback.addEventListener('change', () => toggleHorseRelated(this));
    toggleHorseRelated(onHorseback);

    function toggleHorseRelated(input) {
        var horseRelated = document.getElementsByClassName('horse-related');
        if (input.checked) {
            enableInputs(horseRelated);
        } else {
            disableInputs(horseRelated);
        }
    }
});