/**
 * Singular - Plural Helper
 * @param {number} dataLength - The length of the data.
 * @param {string} singularForm - The word in singular form.
 * @param {string} pluralForm - The word in plural form.
 * @param {boolean} [reverse=true] - Whether to reverse the output format.
 * @returns {string} - The formatted string based on data length.
 */
function SingularPluralHelper(dataLength, singularForm, pluralForm, reverse = true) {
    dataLength = (dataLength) ? dataLength : 0
    let textToDisplay = (dataLength > 1) ? pluralForm : singularForm
    if (!reverse) {
        return `${textToDisplay} (${dataLength})`
    }
    return `${dataLength} ${textToDisplay}`
}

function SingularPluralHelperTextOnly(dataLength, singularForm, pluralForm) {
    let textToDisplay = (dataLength > 1) ? pluralForm : singularForm
    return textToDisplay
}

export { SingularPluralHelper, SingularPluralHelperTextOnly };