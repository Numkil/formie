import { eventKey } from '../utils/utils';

export class FormieTextLimit {
    constructor(settings = {}) {
        this.$form = settings.$form;
        this.form = this.$form.form;
        this.$field = settings.$field;
        this.$text = this.$field.querySelector('[data-max-limit]');
        this.$input = this.$field.querySelector('input, textarea');

        if (this.$text) {
            this.initTextMax();
        } else {
            console.error('Unable to find rich text field “[data-max-limit]”');
        }
    }

    initTextMax() {
        this.maxChars = this.$text.getAttribute('data-max-chars');
        this.maxWords = this.$text.getAttribute('data-max-words');

        if (this.maxChars) {
            this.form.addEventListener(this.$input, eventKey('paste'), this.characterCheck.bind(this), false);
            this.form.addEventListener(this.$input, eventKey('keydown'), this.characterCheck.bind(this), false);

            // Fire immediately
            this.$input.dispatchEvent(new Event('keydown', { bubbles: true }));
        }

        if (this.maxWords) {
            this.form.addEventListener(this.$input, eventKey('paste'), this.wordCheck.bind(this), false);
            this.form.addEventListener(this.$input, eventKey('keydown'), this.wordCheck.bind(this), false);

            // Fire immediately
            this.$input.dispatchEvent(new Event('keydown', { bubbles: true }));
        }
    }

    characterCheck(e) {
        setTimeout(() => {
            // If we're using a rich text editor, treat it a little differently
            var isRichText = e.target.hasAttribute('contenteditable');
            var value = isRichText ? e.target.innerHTML : e.target.value;
            var charactersLeft = this.maxChars - this.count(value);
            var extraClasses = ['fui-limit-number'];
            var type = charactersLeft == 1 || charactersLeft == -1 ? 'character' : 'characters';

            if (charactersLeft < 0) {
                extraClasses.push('fui-limit-number-error');
            }

            this.$text.innerHTML = t('{startTag}{num}{endTag} ' + type + ' left', {
                num: String(charactersLeft),
                startTag: '<span class="' + extraClasses.join(' ') + '">',
                endTag: '</span>',
            });
        }, 1);
    }

    wordCheck(e) {
        setTimeout(() => {
            // If we're using a rich text editor, treat it a little differently
            var isRichText = e.target.hasAttribute('contenteditable');
            var value = isRichText ? e.target.innerHTML : e.target.value;
            var wordCount = this.count(value.split(/\S+/));
            var wordsLeft = this.maxWords - wordCount;
            var extraClasses = ['fui-limit-number'];
            var type = wordsLeft == 1 || wordsLeft == -1 ? 'word' : 'words';

            if (wordsLeft < 0) {
                extraClasses.push('fui-limit-number-error');
            }

            this.$text.innerHTML = t('{startTag}{num}{endTag} ' + type + ' left', {
                num: String(wordsLeft),
                startTag: '<span class="' + extraClasses.join(' ') + '">',
                endTag: '</span>',
            });
        }, 1);
    }

    count(value) {
        // Handles multi-byte like emoji, where `.length` won't be accurate
        // https://javascript.tutorialink.com/how-to-count-the-correct-length-of-a-string-with-emojis-in-javascript/
        return [...value].length;
    }
}

window.FormieTextLimit = FormieTextLimit;
