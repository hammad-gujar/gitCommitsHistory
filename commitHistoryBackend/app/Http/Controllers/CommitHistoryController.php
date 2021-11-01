<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\CommitHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;

class CommitHistoryController extends Controller
{
    public $baseURL = 'https://api.github.com/';
    public $repo = 'repos/nodejs/node/';
    public $endPoint = 'commits';
    public $chunkLimit = 25;
    public $query = '?' . 'per_page=25';

    /**
     * Get commit history from git
     *
     */
    public function getCommitHistory()
    {
        try {
            $url = $this->baseURL . $this->repo . $this->endPoint . $this->query;
            $response = Http::get($url);
        } catch(Exception $ex) {
            Log:info($ex);
        }

        $this->updateCommitHistroy($response->json());
    }

    /**
     * Save git commit histroy in database
     * 
     * @param  $reponse
     *
     */
    public function updateCommitHistroy($reponse)
    {
        try {

            foreach ($reponse as $commit) {
                // Search if commit history is not stored
                if (!CommitHistory::where('sha', '=', $commit['sha'])->exists()) {
                    $commitModel = new CommitHistory();
                    $commitModel->sha = $commit['sha'];
                    $commitModel->author = $commit['commit']['author']['name'];
                    $commitModel->commit_date = Carbon::parse($commit['commit']['author']['date'])->format('Y-m-d h:m:s');
                    $commitModel->save();
                }
            }
        } catch (Exception $ex) {
            Log:info($ex);
        }
    }

    /**
     * Fetch commits from DB
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchHistory(Request $request)
    {

        try{
            $commitData = array();
            if ($request->author !== 'undefined') {
                $commits = DB::table('commit_histories')
                    ->where('author', $request->author)
                    ->orderBy('commit_date', 'desc')
                    ->limit($this->chunkLimit)
                    ->get();
                } else {
                    $commits = DB::table('commit_histories')
                        ->orderBy('commit_date', 'desc')
                        ->limit($this->chunkLimit)
                        ->get();
                }
                
            foreach($commits as $commit)
            {
                $hashLastChar = substr($commit->sha, -1);
                $rowColor = is_numeric($hashLastChar) ? true : false;
                $commitData[] = array(

                    'rowColor' => $rowColor,
                    'author' => $commit->author,
                    'commit_date' => $commit->commit_date,
                    'sha' => $commit->sha
                );
            }

            return response()->json($commitData, 200);

        } catch (HttpException $ex) {
            return response()->json(['Exception' => $ex], 401);
        }
    }

}
