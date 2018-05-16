async function main() {
  const response = await fetch('/api/entries');
  const { data } = await response.json();
  console.log(data);
 }
 main();