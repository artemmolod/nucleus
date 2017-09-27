describe("Unit Test", function() {
    
    describe("pow", function() {
        var expected = 2 * 2 * 2;
        it("при возведении числа 2 в степень 3 результат: " + expected, function() {
            assert.equal(pow(2, 3), expected); 
        });
    }); 
    
});
