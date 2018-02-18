<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Result;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends Controller
{
    /**
     * @Route("/main/quizResults/{slug}",
     *     name="QuizResults",
     *     )
     */
    public function ShowQuizResults(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('quizname' => $slug);
        $arr = $em->getRepository(Quiz::class)->findBy($criteria);
        $currentQuiz = $arr[0];

        $questionsAmount = count($currentQuiz->getQuestionList());

        $criteria = array('quiz' => $currentQuiz->getId());
        $currentQuizResults = $em->getRepository(Result::class)->findBy($criteria);
        $arrayUser_correctAnswersAmount = $this->getUsersOfCurrentQuiz($currentQuizResults);
        uasort($arrayUser_correctAnswersAmount, function($a, $b) {
            return $b - $a;
        });
        $userPlace = $this->findOutUserPlace($arrayUser_correctAnswersAmount);
        return $this->render('Quizzes/quizResult.html.twig', array(
            'quizName' => $currentQuiz->getQuizName(),
            'array' => $arrayUser_correctAnswersAmount,
            'currentQuizResults' => $currentQuizResults,
            'questionsAmount' => $questionsAmount,
            'userPlace' => $userPlace,
        ));
    }

    private function getUsersOfCurrentQuiz(array $currentQuizResults): array
    {
        $arrayUser_correctAnswersAmount = [];
        foreach ($currentQuizResults as $result) {
            $currentUser = $result->getUser()->getUsername();
            $arrayUser_correctAnswersAmount[$currentUser] = 0;
        }
        foreach ($currentQuizResults as $result) {
            $currentUser = $result->getUser()->getUsername();
            $currentResultCorrectness = $result->getAnswer()->getisTrue();
            if ($currentResultCorrectness) {
                $arrayUser_correctAnswersAmount[$currentUser]++;
            }
        }
        return $arrayUser_correctAnswersAmount;
    }

    private function findOutUserPlace(array $arrayUser_correctAnswersAmount): int
    {
        $username = $this->getUser()->getUsername();
        foreach (array_keys($arrayUser_correctAnswersAmount) as $key => $value) {
            if ($value == $username) {
                return $key + 1;
            }
        }
    }
}