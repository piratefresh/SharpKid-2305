const finalScore = document.getElementById("finalScore");
const mostRecentScore = localStorage.getItem(mostRecentScore);

finalScore.innerText = mostRecentScore;
highScores = localStorage.JSON.parse(localStorage.getItem("highScores")) || [];
const MAX_HIGH_SCORES = 5;
console.log(highScores);

saveHighScore = e => {
  console.log("clicked the save button");

  const score = {
    score: mostRecentScore,
    name: userName.value
  };
  highScores.push(score);

  highScores.sort((a, b) => b.score - a.score);
  highScores.splice(5);

  localStorage.setItem("highScores", JSON.stringify(highScores));
  console.log(highScores);
};
