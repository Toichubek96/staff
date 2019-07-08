<?php

use App\Models\Profiles;
use App\Models\Users;
use App\Models\Hours;
use  App\Models\Late;
use App\Forms\ChangePasswordForm;
use lib\Funcions;


class UsersController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('user');
    }

    public function indexAction($year_ = null, $month_ = null)
    {
//        $date = new \DateTime('2019-06-14');
//        echo date("h:i:s");
//        return false;
        $months = array(
            array('number' => '01', 'name' => 'January'),
            array('number' => '02', 'name' => 'February'),
            array('number' => '03', 'name' => 'March'),
            array('number' => '04', 'name' => 'April'),
            array('number' => '05', 'name' => 'May'),
            array('number' => '06', 'name' => 'June'),
            array('number' => '07', 'name' => 'July'),
            array('number' => '08', 'name' => 'August'),
            array('number' => '09', 'name' => 'September'),
            array('number' => '10', 'name' => 'October'),
            array('number' => '11', 'name' => 'November'),
            array('number' => '12', 'name' => 'December'),

        );
        $days = array();
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuday'];
        $date = null;
        $year = null;
        $currentMonth = null;
        $currentDay = null;
        $isCurrentDate = false;
        $oldNew = null;
        $date = new \DateTime(null, new DateTimeZone('Asia/Almaty'));
        $result = $date->format('Y-m');
        $year = $date->format('Y');
        $currentMonth = $date->format('m');
        if ($year_ && $month_ && ($month_ != $currentMonth || $year_ != $year)) {
            $date = new \DateTime($year_ . '-' . $month_, new DateTimeZone('Asia/Almaty'));
            $year = $date->format('Y');
            $currentMonth = $date->format('m');
            $currentDay = $date->format('d');
            $date1 = strtotime($result);
            $date2 = strtotime($year_ . '-' . $month_);
            if ($date1 > $date2) {
                $oldNew = 1;
            } else {
                $oldNew = 2;
            }

        } else {
            $currentDay = $date->format('d');
            $isCurrentDate = true;
        }


        $number = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $year);
        $index = 0;
        $day = null;
        for ($i = 1; $i <= $number; $i++) {
            $date = new \DateTime($year . '-' . $currentMonth . '-' . ($i));
            $dateString = $date->format('Y-m-d H:i:s');
//            $day = null;
//            var_dump($day);
            $year = $date->format('Y');
//            if ($isCurrentDate) {
            $day = $date->format('d');
//            }

            $daysOfWeekIndex = date('w', strtotime($dateString));
            $days[$index] = array('number' => $i, 'name' => $daysOfWeek[$daysOfWeekIndex], 'day' => $day);
            $index++;
        }


//        return false;
        //***********users block************
        // get current user
        $currentUser = $this->auth->getUser();
        //get other users
        $users = Users::query()
            ->where('id <> :id:')
            ->andWhere('profilesId <>:profilesId:')
            ->bind(['id' => $currentUser->id, 'profilesId' => 2,])
            ->execute();
        //get hours for current user
        $hoursCurrentUser = Hours::query()
            ->where('userId = :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $currentUser->id, 'month' => $month_, 'year' => $year_])
            ->execute();
        //get hour for other users
        $hoursOtherUser = Hours::query()
            ->where('userId <> :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $currentUser->id, 'month' => $month_, 'year' => $year_])
            ->execute();


        $this->view->setVars(
            [
                "year" => $year,
                'currentMonth' => $currentMonth,
                "months" => $months,
                "days" => $days,
                "currentDay" => $currentDay,
                'currentUser' => $currentUser,
                'users' => $users,
                'isCurrentDate' => $isCurrentDate,
                'oldNew' => $oldNew,
                'hoursCurrentUser' => $hoursCurrentUser,
                'hoursOtherUser' => $hoursOtherUser
            ]
        );


    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }

    /**
     * Change password
     */

    public function changePasswordAction()
    {

        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = $this->auth->getUser();
                $user->password = $this->request->getPost('password');
                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {

                    $this->flash->success('Your password was successfully changed');

                }


            }
        }

        $this->view->form = $form;

    }

    public function startAction($userId, $first)
    {
//        print_die($year . " " . $month . " " . $today . " " . $userId);
//        date_default_timezone_set('Asia/Almaty');
        $currentDate = new \DateTime(null, new DateTimeZone('Asia/Almaty'));
        $year = $currentDate->format('Y');
        $month = $currentDate->format('m');
        $day = $currentDate->format('d');
        $start = $currentDate->format('H:i');
        if ($first != 'false') {
            if (Funcions::isLate($start)) {
                $late = new Late([
                        "year" => $year,
                        "month" => $month,
                        "day" => $day,
                        "userId" => $userId

                    ]

                );
                if (!$late->save()) {
                    $this->flash->error($late->getMessages());
                    return false;
                }

            }

        }

        $hour = new Hours([
            'start' => $start,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'userId' => $userId
        ]);
        if ($hour->save()) {
            return $this->response->redirect("users/table/$year/$month");
        } else {
            $this->flash->error($hour->getMessages());
        }


    }

    public function stopAction($hourId)
    {
        $currentDate = new \DateTime(null, new DateTimeZone('Asia/Almaty'));
        $year = $currentDate->format('Y');
        $month = $currentDate->format('m');
        $end = $currentDate->format('H:i');
        $hour = Hours::findFirstById($hourId);
        $hour->end = $end;
        if ($hour->save()) {
            return $this->response->redirect("users/table/$year/$month");
        } else {
            $this->flash->error($hour->getMessages());
        };


    }

    public function tableAction($year = -1, $month = -1)
    {

        $currentDate = new \DateTime(null, new DateTimeZone('Asia/Almaty'));
        $currentYear = $currentDate->format('Y');
        $currentMonth = $currentDate->format('m');
        $today = $currentDate->format('d');
        if ($year != -1 && $month != -1) {
            if ($currentYear != $year || $currentMonth != $month) {
                $NotCurrentDate = new \DateTime($year . '-' . $month, new DateTimeZone('Asia/Almaty'));
                if ($NotCurrentDate < $currentDate) {
                    $currentOldNewDate = 2;
                } else {
                    $currentOldNewDate = 3;
                }
                $year = $NotCurrentDate->format('Y');
                $month = $NotCurrentDate->format('m');

            } else {
                $currentOldNewDate = 1;
                $year = $currentYear;
                $month = $currentMonth;
            }

        } else {
            $currentOldNewDate = 1;
            $year = $currentYear;
            $month = $currentMonth;
        }
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days = array();
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuday'];
        $index = 0;
        for ($i = 1; $i <= $number; $i++) {
            $date = new \DateTime($year . '-' . $month . '-' . ($i));
            $dateString = $date->format('Y-m-d H:i:s');
//            $year = $date->format('Y');
            $day = $date->format('d');
            $daysOfWeekIndex = date('w', strtotime($dateString));
//            if ('08' == $day) {
            $days[$index] = array(
                'number' => $i,
                'name' => $daysOfWeek[$daysOfWeekIndex],
                'day' => $day,
                'dayOff' => 0
            );
//            } else {
//                $days[$index] = array(
//                    'number' => $i,
//                    'name' => $daysOfWeek[$daysOfWeekIndex],
//                    'day' => $day,
//                    'dayOff' => 0
//                );
//            }

            $index++;
        }
        // get current user
        $currentUser = $this->auth->getUser();
        //get current user hours
        $currentUserHours = Hours::getCurrentUserHours($currentUser->id, $year, $month);
        //get current users's today's hours
        $currentUserTodayHours = Hours::getCurrentUserHoursForToday($currentUser->id, $year, $month, $today);
        //get current user's late list
        $currentUserLateList = Late::getCurrentUserLateList($currentUser->id, $year, $month);
//        print_die($currentUserLateList);
        //get other users
        $otherUsers = Users::getOtherUsers($currentUser->id);
        //get other users hours
        $otherUsersHours = Hours::getOtherUsersHours($currentUser->id, $year, $month);
        //get other users late list
        $otherUserLateList = Late::getOtherUsersLateList($currentUser->id, $year, $month);
//        print_die($otherUserLateList);
//        print_die($year . $month . $today);

        $this->view->setVars(
            [
                "days" => $days,
                'currentUser' => $currentUser,
                'otherUsers' => $otherUsers,
                'currentOldNewDate' => $currentOldNewDate,
                'currentUserHours' => $currentUserHours,
                'otherUsersHours' => $otherUsersHours,
                "year" => $year,
                "month" => $month,
                'today' => $today,
                'currentUserLateList' => $currentUserLateList,
                'otherUserLateList' => $otherUserLateList,
                'currentUserTodayHours' => $currentUserTodayHours

            ]
        );


    }

}

