<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worksplace;
use App\Models\TypeWorkday;
use App\Models\User;
use App\Models\CandidateWorksplace;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class WorksplaceController extends Controller
{
    public function ListWorksplace()
    {
        $worksplace = Worksplace::select(
            'tb_worksplaces.id',
            'tb_worksplaces.title',
            'tb_worksplaces.description',
            'tb_types_workday.id as workday_id',
            'tb_types_workday.name as workday',
            'tb_worksplaces.salary',
            'tb_worksplaces.created_at',
            'tb_worksplaces.updated_at',
            DB::raw('(select count(candidate_id) from candidates_has_worksplaces where worksplace_id = tb_worksplaces.id) as candidates_has_worksplaces')
        )
            ->join('tb_types_workday', 'tb_types_workday.id', '=', 'tb_worksplaces.type_workday_id')->orderBy('tb_worksplaces.created_at', 'desc')->orderBy('tb_worksplaces.updated_at', 'desc')->paginate(5);
        return response()->json($worksplace);
    }
    public function ListWorksplacePost($user_id)
    {
        $candidate = Candidate::where('user_id', $user_id)->first();
        $candidate_id = $candidate->id;
        $worksplace = Worksplace::select(
            'tb_worksplaces.id',
            'tb_worksplaces.title',
            'tb_worksplaces.description',
            'tb_types_workday.id as workday_id',
            'tb_types_workday.name as workday',
            'tb_worksplaces.salary',
            'tb_worksplaces.created_at',
            'tb_worksplaces.updated_at',
            DB::raw('(select count(candidate_id) from candidates_has_worksplaces where worksplace_id = tb_worksplaces.id) as candidates_has_worksplaces')
        )
            ->join('tb_types_workday', 'tb_types_workday.id', '=', 'tb_worksplaces.type_workday_id')
            ->join('candidates_has_worksplaces', function (JoinClause $join) use ($candidate_id) {
                $join->on('tb_worksplaces.id', '=', 'candidates_has_worksplaces.worksplace_id')
                    ->where('candidates_has_worksplaces.candidate_id', '=', $candidate_id);
            })
            ->orderBy('tb_worksplaces.created_at', 'desc')
            ->orderBy('tb_worksplaces.updated_at', 'desc')->paginate(5);
        return response()->json($worksplace);
    }
    public function OptionsWorkday()
    {
        $workdays = TypeWorkday::all();
        return response()->json($workdays);
    }

    public function CandidatesWorksplace($worksplaces_id)
    {
        $CandidatesWorksplace = CandidateWorksplace::select(
            'tb_worksplaces.id as worksplaces_id',
            'tb_candidates.id',
            'tb_candidates.n_document',
            DB::raw('(select name from tb_types_document where id = tb_candidates.type_document_id limit 1) as type_document'),
            'tb_candidates.names',
            'tb_candidates.last_names',
            'tb_candidates.dates_birth',
            'tb_candidates.email',
            'candidates_has_worksplaces.file_cv',
            'candidates_has_worksplaces.message',
            'candidates_has_worksplaces.created_at',
            'candidates_has_worksplaces.updated_at',
        )
            ->join('tb_candidates', 'tb_candidates.id', '=', 'candidates_has_worksplaces.candidate_id')
            ->join('tb_worksplaces', function (JoinClause $join) use ($worksplaces_id) {
                $join->on('tb_worksplaces.id', '=', 'candidates_has_worksplaces.worksplace_id')
                    ->where('tb_worksplaces.id', '=', $worksplaces_id);
            })
            ->get();
        return response()->json($CandidatesWorksplace);
    }
    public function CreatePostWorksplace(Request $request)
    {
        request()->validate(CandidateWorksplace::$rules, CandidateWorksplace::$customMessages);

        if ($request->hasFile('file_cv')) {
            $filename = $request->file_cv->getClientOriginalName();
            $request->file_cv->move(public_path('upload'), $filename);
        }

        $candidate_id = Candidate::where('user_id', $request->input('user_id'))->first();
        CandidateWorksplace::create([
            'candidate_id' => $candidate_id->id,
            'worksplace_id' => $request->input('worksplace_id'),
            'file_cv' => $filename,
            'message' => $request->input('message')
        ]);
    }
    public function CheckPostWorksplace($id_user, $worksplace_id)
    {
        $candidate_id = Candidate::where('user_id', $id_user)->first();
        if (!empty($candidate_id)) {
            $checkPost =  CandidateWorksplace::where('candidate_id', $candidate_id->id,)->where('worksplace_id', $worksplace_id)->get();
            return response()->json($checkPost);
        }
    }
    public function CreateWorksplace(Request $request)
    {
        request()->validate(Worksplace::$rules, Worksplace::$customMessages);
        Worksplace::create($request->all());
    }
    public function UpdateWorksplace($id, Request $request)
    {
        $worksplace = Worksplace::find($id);
        request()->validate(Worksplace::$rules, Worksplace::$customMessages);
        $worksplace->update($request->all());
    }
    public function DestroyWorksplace($id, Request $request)
    {
        Worksplace::find($id)->delete();
    }
    function DowloadFileCVPost($file_name)
    {
        $path = public_path() . '/upload/' . $file_name;
        $header = [
            'Content-Type' => 'application/*',
        ];
        return response()->download($path, $file_name, $header);
    }
}
