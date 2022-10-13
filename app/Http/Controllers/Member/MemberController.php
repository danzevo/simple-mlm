<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\Member;
use App\Http\Requests\Member\StoreRequest;
use DB;

class MemberController extends Controller
{
    public function index(Request $request) {
        try {
            $member = Member::all();

            $list = $this->getList();

            return view('Member/index', compact('member', 'list'));
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function getList($parent_id = 0, $level = 0) {
        try {
            // get level 1
            $member = Member::where('parent_id', $parent_id)->get();

            $data = $member->map(function($item) use ($level) {
                $level += 1;

                $request = new Request([
                    'id' => $item->id,
                    'level' => 'all',
                ]);

                $bonus = $this->calculateBonus($request);
                $bonus = json_decode(json_encode($bonus), true);

                // get level 2
                $get_member = Member::where('parent_id', $item->id)->count();

                $get_child = [];
                if($get_member > 0) {
                    $get_child[] = $this->getList($item->id, $level);
                }

                return [
                    'name' => $item->name,
                    'member_id' => $item->member_id,
                    'level' => $level,
                    'bonus' => $bonus['original']['total_bonus'],
                    'child' => $get_child
                ];
            })->toArray();

            return $data;
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function fetchData() {
        try {
            $list = $this->getList();

            $hasil = '';
            if(count($list) > 0) {
                foreach($list as $row) {
                    $hasil .= '<li>';
                        $hasil .= '<a href="#">'.$row['name'].' lv. '.$row['level'].'<br>( Bonus : $'.$row['bonus'] .' )</a>';
                        $hasil .= $this->fetchChild($row['child']);
                    $hasil .= '</li>';
                }
            }

            echo $hasil;
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function fetchChild($list) {
        try {
            $hasil = '';
            if(count($list) > 0) {
                $hasil .= '<ul>';
                $i=0;
                foreach($list as $res) {
                    foreach($res as $r) {
                        $hasil .= '<li>';
                            $hasil .= '<a href="#">'.$r['name'].' lv. '.$r['level'].'<br>( Bonus : $'.$r['bonus'] .' )</a>';
                            $hasil .= $this->fetchChild($r['child']);
                        $hasil .= '</li>';
                        $i++;
                    }
                }
                $hasil .= '</ul>';
            }

            return $hasil;
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function store(StoreRequest $request) {
        DB::beginTransaction();
        try {
            $member = Member::orderBy('id', 'desc')->first();

            $member_id = '0001';
            if($member) {
                $member_id = (int)$member->member_id;
                $member_id += 1;
                $member_id = substr('0000',0,4-strlen($member_id)).$member_id;
            }

            $item = Member::create([
                'name' => $request->name,
                'member_id' => $member_id,
                'parent_id' => $request->parent_id ?? 0,
            ]);

            DB::commit();
            return response()->json(['message' => 'Data successfull created'], 201);
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try {
            $member = Member::find($id);
            if(!$member)
                return response()->json(['message' => 'Data not found'], 404);

            $member->update([
                'parent_id' => $request->parent_id ?? 0,
            ]);

            DB::commit();
            return response()->json(['message' => 'Data successfull updated'], 200);
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function calculateBonus(Request $request) {
        try {
            $id = $request->id;
            $level = $request->level;

            // jika 1 level dibawahnya
            if($level == 2) {
                $count_member = Member::where('parent_id', $id)->count();
                $total_bonus = 1 * $count_member;
            } elseif($level == 3) {
                // jika 2 level dibawahnya
                $level_2 = Member::where('parent_id', $id)->get();

                $total_bonus = 0;
                foreach($level_2 as $row) {
                    $count_member = Member::where('parent_id', $row->id)->count();
                    $total_bonus += ($count_member * 0.5);
                }
            } elseif($level == 'all') {
                // jika 1 level dibawahnya
                $member = Member::where('parent_id', $id);
                $count_member = $member->count();
                $total_bonus = 1 * $count_member;

                $level_2 = $member->get();
                // jika 2 level dibawahnya
                foreach($level_2 as $row) {
                    $count_member = Member::where('parent_id', $row->id)->count();
                    $total_bonus += ($count_member * 0.5);
                }
            }

            return response()->json(['message' => 'Data successfull updated', 'total_bonus' => $total_bonus], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
