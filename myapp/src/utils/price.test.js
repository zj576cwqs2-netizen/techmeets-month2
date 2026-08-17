import { describe, test, expect } from 'vitest'
import { calcTaxIncluded } from './price'

describe('calcTaxIncluded(1000)', () => {
    test('should calculate tax included price', () => {
        expect(calcTaxIncluded(1000)).toBe(1100)
    })

    test('端数は切り捨てになる', () => {
        expect(calcTaxIncluded(105, 0.08)).toBe(113)
    });

    test('0円の商品は0円になる', () => {
        expect(calcTaxIncluded(0)).toBe(0)
    });
})