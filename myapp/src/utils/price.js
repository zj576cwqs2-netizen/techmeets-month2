export function calcTaxIncluded(price, taxRate = 0.1){
    return Math.floor(price * (1 + taxRate))

}