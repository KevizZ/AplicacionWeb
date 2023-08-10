let numbers = [10,20,30,40,50];
console.log(numbers.length);

let secondNumber = numbers[1];
console.log(secondNumber);

numbers[3] = 60;
console.log(numbers);

let fruits = [];
fruits.push("apple","banana","orange");
console.log(fruits);

fruits.pop();
console.log(fruits);

let mixedArray = ["hello",5,true,["a","b","c"]]
console.log(mixedArray[2]);

let letters = "abcdefg".split("");
console.log(letters);

let joinedString = letters.join("->");
console.log(joinedString);

console.log(numbers.includes(25));

console.log(fruits.indexOf("orange"));
