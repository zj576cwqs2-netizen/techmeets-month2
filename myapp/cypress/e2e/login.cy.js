describe('ログイン画面', () => {
  it('ログインページが表示される', () => {
    cy.visit('/login')
    cy.get('form').should('exist')
  })

  it('トップページが表示される', () => {
    cy.visit('/')
    cy.contains('Laravel')
  })
})
