<?php

class Booking_bridge extends Model {

    public $type;
    public $typeName;

    public function __construct($type = 0) {
        parent::__construct();
        $this->type = $type;
        $this->getTypeName();
        $this->view->searchVar = array(
            'type' => $this->type,
        );
        if(!$this->view->lang){
            $this->loadLang();
            $this->view->lang=$this->lang;
        }
    }

    public function searchForm() {
        $action = URL . $this->typeName . '/results';
        $numPeople[0] = "0";
        $numChild[0] = "0";
        for ($i = 1; $i <= 14; $i++) {
            $numPeople[$i] = $i;
            $numChild[$i] = $i;
        }
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('search', 'GET', $action, $atributes);
        $form->add('hidden', 'price', '');
        $destination=$this->getSectionsByName(Session::get('destination'));
        $form->add('hidden', 'destination',$destination['home_sections_id'] );
        $form->add('hidden', 'type', $this->type);
        $form->add('text', 'name', '', array('placeholder' => strtoupper($this->typeName) .' '. $this->lang['name, city or country']));

        $form->add('label', 'label_adults', 'adults', 'ADULTS:');
        $obj = $form->add('select', 'adults', 2);
        $obj->add_options($numPeople, true);
        $form->add('label', 'label_children', 'children', 'CHILDREN:');
        $obj = $form->add('select', 'children', '');
        $obj->add_options($numChild, true);
        $form->add('text', 'price', '');
        $form->add('text', 'checkin', '', array('placeholder' => $this->lang['check in']));
        $form->add('text', 'checkout', '', array('placeholder' => $this->lang['check out']));

        $obj = $form->add('radios', 'category', $this->getOptions($this->type));
        $form->add('submit', '_btnsubmit', $this->lang['search'].' ' . $this->typeName);

        if ($form->validate()) {
            
        }
        return $form;
    }

    public function CheckAvailabilityForPeriod($room_id, $checkin_date, $checkout_date, $avail_rooms = 0) {
        $available_rooms = $avail_rooms;
        $available_until_approval = ModulesSettings::Get('booking', 'available_until_approval');

        // calculate total sum, according to week day prices
        $current_date = strtotime($checkin_date);
        $current_year = date('Y');
        $end = strtotime($checkout_date);
        $m_old = '';

        while ($current_date < $end) {
            $y = date('Y', $current_date);
            $m = date('m', $current_date);
            $d = date('d', $current_date);

            if ($m_old != $m) {
                $sql = 'SELECT * 
                FROM ' . DB_PREFIX . 'rooms_availabilities ra
                WHERE ra.room_id = ' . (int) $room_id . ' AND
                ra.y = ' . (($y == $current_year) ? '0' : '1') . ' AND
                ra.m = ' . (int) $m;
                $result = $this->db->select($sql);
            }

            if (sizeof($result) > 0) {
                if ($result[0]['d' . (int) $d] <= 0) {
                    return 0;
                } else {
                    $current_date_formated = date('Y-m-d', $current_date);
                    // check maximal booked rooms for this day!!!
                    $sql = 'SELECT
                    SUM(' . DB_PREFIX . 'bookings_rooms.rooms) as total_booked_rooms
                    FROM ' . DB_PREFIX . 'bookings
                    INNER JOIN ' . DB_PREFIX . 'bookings_rooms ON ' . DB_PREFIX . 'bookings.booking_number = ' . DB_PREFIX . 'bookings_rooms.booking_number
                    WHERE
                        (' . (($available_until_approval == 'yes') ? '' : DB_PREFIX . 'bookings.status = 1 OR ') . ' ' . DB_PREFIX . 'bookings.status = 2) AND
                        ' . DB_PREFIX . 'bookings_rooms.room_id = ' . (int) $room_id . ' AND
                        (
                                (\'' . $current_date_formated . '\' >= checkin AND \'' . $current_date_formated . '\' < checkout) 
                                OR
                                (\'' . $current_date_formated . '\' = checkin AND \'' . $current_date_formated . '\' = checkout) 
                        )';
                    $result1 = $this->db->select($sql);
                    if (sizeof($result1) > 0) {
                        if ($result1[0]['total_booked_rooms'] >= $result[0]['d' . (int) $d]) {
                            return 0;
                        } else {
                            $available_diff = $result[0]['d' . (int) $d] - $result1[0]['total_booked_rooms'];
                            if ($available_diff < $available_rooms) {
                                $available_rooms = $available_diff;
                            }
                        }
                    }
                }
            } else {
                return 0;
            }
            $m_old = $m;
            $current_date = strtotime('+1 day', $current_date);
        }
        return $available_rooms;
    }

    /**
     * Search available rooms
     * 		@param $params
     */
    public function check_availability($params = array()) {
        $params = $this->getParams();
        $checkin_date = isset($params['checkin_date']) ? $params['checkin_date'] : '';
        $checkout_date = isset($params['checkout_date']) ? $params['checkout_date'] : '';
        $max_adults = isset($params['max_adults']) ? $params['max_adults'] : '';
        $max_children = isset($params['max_children']) ? $params['max_children'] : '';
        $room_id = isset($params['room_id']) ? $params['room_id'] : '';
        $hotel_sel_id = isset($params['hotel_sel_id']) ? $params['hotel_sel_id'] : '';
        $hotel_sel_loc_id = isset($params['hotel_sel_loc_id']) ? $params['hotel_sel_loc_id'] : '';
        $rango = isset($params['rango']) ? $params['rango'] : '';
        $category = isset($params['category']) ? $params['category'] : '';
        $name = isset($params['name']) ? $params['name'] : '';
        $destination = isset($params['destination']) ? $params['destination'] : '';

        $order_by_clause = (isset($params['sort_by'])) ? (($params['sort_by'] == '1-5') ? 'h.stars ASC' : 'h.stars DESC') : 'r.priority_order ASC';
        $hotel_where_clause = (!empty($hotel_sel_id)) ? 'h.id = ' . (int) $hotel_sel_id . ' AND ' : '';
        $hotel_where_clause .= (!empty($hotel_sel_loc_id)) ? 'h.hotel_location_id = ' . (int) $hotel_sel_loc_id . ' AND ' : '';
        $hotel_where_clause .= (!empty($rango)) ? 'r.default_price <= ' . $rango . ' AND ' : '';
        $hotel_where_clause .= (!empty($category)) ? 'h.category = ' . (int) $category . ' AND ' : '';
        $hotel_where_clause .= (!empty($name)) ? 'hd.name LIKE "%' . $name . '%" AND ' : '';
        $hotel_where_clause .= (!empty($destination)) ? 'hl.section =' . $destination . ' AND ' : '';

        $rooms_count = 0;
        $show_fully_booked_rooms = ModulesSettings::Get('booking', 'show_fully_booked_rooms');

        $sql = 'SELECT r.id as room_id,r.room_icon,h.category,r.default_price ,r.beds , r.hotel_id, r.room_count,h.hotel_image,r.max_adults, r.max_children,r.room_count, hd.name, hd.description,rd.room_short_description,rd.room_type,rap.mon as adult_price,rcp.mon as children_price
		FROM ' . DB_PREFIX . 'rooms r
		INNER JOIN ' . DB_PREFIX . 'hotels h ON r.hotel_id = h.id
		INNER JOIN ' . DB_PREFIX . 'hotels_locations hl ON hl.id = h.hotel_location_id
                INNER JOIN ' . DB_PREFIX . 'hotels_description hd ON h.id = hd.hotel_id
                INNER JOIN ' . DB_PREFIX . 'rooms_description rd ON r.id = rd.room_id
                INNER JOIN ' . DB_PREFIX . 'rooms_prices rap ON (r.id = rap.room_id AND rap.is_default=1 AND rap.adults>0)
                INNER JOIN ' . DB_PREFIX . 'rooms_prices rcp ON (r.id = rcp.room_id AND rcp.is_default=1 AND rcp.children>0)
                WHERE 1=1 AND h.type=' . $this->type . ' AND
                ' . $hotel_where_clause . '
                h.is_active = 1 AND
                r.is_active = 1					
                ' . (($room_id != '') ? ' AND r.id=' . (int) $room_id : '') . /* '
                  '.(($max_adults != '') ? ' AND r.max_adults >= '.(int)$max_adults : '').'
                  '.(($max_children != '') ? ' AND r.max_children >= '.(int)$max_children : ''). */'
                GROUP BY r.id 
                ORDER BY ' . $order_by_clause;
        $rooms = $this->db->select($sql);
        if (sizeof($rooms) > 0) {
            // loop by rooms
            foreach ($rooms as $room) {
                // maximum available rooms in hotel for one day
                $maximal_rooms = (int) $room['room_count'];
                $max_booked_rooms = '0';
                $sql = 'SELECT MAX(' . DB_PREFIX . 'bookings_rooms.rooms) as max_booked_rooms
                FROM ' . DB_PREFIX . 'bookings
                INNER JOIN ' . DB_PREFIX . 'bookings_rooms ON ' . DB_PREFIX . 'bookings.booking_number = ' . DB_PREFIX . 'bookings_rooms.booking_number
                WHERE
                (' . DB_PREFIX . 'bookings.status = 1 OR ' . DB_PREFIX . 'bookings.status = 2) AND
                ' . DB_PREFIX . 'bookings_rooms.room_id = ' . (int) $room['room_id'] . ' AND
                (
                        (\'' . $checkin_date . '\' <= checkin AND \'' . $checkout_date . '\' > checkin) 
                        OR
                        (\'' . $checkin_date . '\' < checkout AND \'' . $checkout_date . '\' >= checkout)
                        OR
                        (\'' . $checkin_date . '\' >= checkin  AND \'' . $checkout_date . '\' < checkout)
                )';
                $rooms_booked = $this->db->select($sql);
                if (sizeof($rooms_booked) > 0) {
                    $max_booked_rooms = (int) $rooms_booked[0]['max_booked_rooms'];
                }
                // this is only a simple check if there is at least one room wirh available num > booked rooms
                $available_rooms = (int) ($maximal_rooms - $max_booked_rooms);
                // echo '<br> Room ID: '.$room['id'].' Max: '.$maximal_rooms.' Booked: '.$max_booked_rooms.' Av:'.$available_rooms;
                // this is advanced check that takes in account max availability for each spesific day is selected period of time

                $fully_booked_rooms = true;

                if ($available_rooms > 0) {
                    $available_rooms_updated = $this->CheckAvailabilityForPeriod($room['room_id'], $checkin_date, $checkout_date, $available_rooms);
                    $slots = ($room['max_adults'] + $room['max_children']) * $available_rooms_updated;
                    $tooMany = ($available_rooms_updated * $room['max_adults'] >= $max_adults && $available_rooms_updated * $room['max_children'] >= $max_children) ? false : true;
                    if ($available_rooms_updated && !$tooMany) {
                        $rooms_count++;
                        $room['available_rooms'] = $available_rooms_updated;
                        $room['slots'] = $slots;
                        $room['img'] = HOTEL_GALLERY.$room['room_icon'];
                        $this->arrAvailableRooms[$room['hotel_id']][] = $room;
                        $fully_booked_rooms = false;
                    }
                }

//				if($show_fully_booked_rooms == 'yes' && $fully_booked_rooms){
//					$rooms_count++;
//					$this->arrAvailableRooms[$room['hotel_id']][] = array('id'=>$room['id'], 'available_rooms'=>'0');
//				}
            }
        }
        return $rooms_count;
    }

    public function getParams() {
        list($checking['year'], $checking['month'], $checking['day']) = explode('-', $_GET['checkin']);
        list($checkout['year'], $checkout['month'], $checkout['day']) = explode('-', $_GET['checkout']);
        $this->params = Array(
            'type' => $this->type,
            'checkin_date' => $_GET['checkin'],
            'checkout_date' => $_GET['checkout'],
            'from_year' => $checking['year'],
            'from_month' => $checking['month'],
            'from_day' => $checking['day'],
            'to_year' => $checkout['year'],
            'to_month' => $checkout['month'],
            'to_day' => $checkout['day'],
            'max_adults' => $_GET['adults'],
            'max_children' => $_GET['children'],
            'rango' => $_GET['rango'],
            'category' => $_GET['category'],
            'name' => $_GET['name'],
            'destination' => $_GET['destination'],
        );
        return $this->params;
    }

    public function getBookingInfo() {
        $booking = Array(
            'adults' => $_GET['adults'],
            'children' => $_GET['children'],
            'checkin' => $_GET['checkin'],
            'checkout' => $_GET['checkout'],
        );
        list($booking['from_year'], $booking['from_month'], $booking['from_day']) = explode('-', $_SESSION['checkin']);
        list($booking['to_year'], $booking['to_month'], $booking['to_day']) = explode('-', $_SESSION['checkout']);
        return $booking;
    }

    public function getSuggestions($lang = 'en') {
        $sugestions = $this->db->select('SELECT *,p.created_at as imgdate,s.id as sugid,p.*  FROM suggestions s JOIN suggestions_description sd ON sd.suggestion_id=s.id JOIN photos p ON s.photo_id=p.id JOIN suggestions_groups sg ON sg.id=s.`group` WHERE sd.language_id=:lang AND s.visibility="public" AND sg.visibility="public" ORDER BY s.`group`,s.`position`', array('lang' => $lang));

        foreach ($sugestions as $value) {
            $return[$value['group']]['suggestion'][] = $value;
        }
        $group = $this->db->select('SELECT * FROM suggestions_groups s JOIN suggestions_groups_description sd ON sd.suggestions_group_id=s.id WHERE sd.language_id=:lang AND s.visibility="public" ORDER by position', array('lang' => $lang));
        foreach ($group as $value) {
            $return[$value['suggestions_group_id']]['info'] = $value;
        }
        return $return;
    }

    function getHotelInfo($id, $lang = LANG) {
        $sql = 'SELECT r.id, r.hotel_id, h.map_image, r.room_count,h.hotel_image,r.max_adults, r.max_children,r.room_count, hd.name, hd.description, hd.short_description,rd.room_short_description,rd.room_type,rp.*,h.*
		FROM ' . DB_PREFIX . 'rooms r
		INNER JOIN ' . DB_PREFIX . 'hotels h ON r.hotel_id = h.id
                INNER JOIN ' . DB_PREFIX . 'hotels_description hd ON h.id = hd.hotel_id AND hd.language_id="'.$lang.'"
                INNER JOIN ' . DB_PREFIX . 'rooms_description rd ON r.id = rd.room_id AND rd.language_id="'.$lang.'"
                INNER JOIN ' . DB_PREFIX . 'rooms_prices rp ON r.id = rp.room_id
                WHERE 1=1 AND 
                h.is_active = 1 AND
                r.is_active = 1					
                ' . (($id != '') ? ' AND h.id=' . (int) $id : '');
        
        $hotel = $this->db->selectOne($sql);
        $result = array(
            'name' => $hotel['name'],
            'description' => $hotel['description'],
            'short_description' => $hotel['short_description'],
            'author_picture' => $hotel['author_picture'],
            'author_name' => $hotel['author_name'],
            'map_code' => $hotel['map_code'],
            'map_image' => $hotel['map_image'],
            'policies' => $hotel['policies'],
        );
        for ($i = 1; $i <= 4; $i++) {
            $result['gallery'][$i] = ($hotel['room_picture_' . $i]) ? HOTEL_GALLERY . $hotel['room_picture_' . $i] : null;
        }
        return $result;
    }

    function getRoomsHotel($id, $lang = LANG) {
        $sql = 'SELECT r.*,rd.*,rap.mon as adult_price,rcp.mon as children_price FROM ' . DB_PREFIX . 'rooms r '
                . 'JOIN ' . DB_PREFIX . 'rooms_description rd ON rd.room_id=r.id '
                .'INNER JOIN ' . DB_PREFIX . 'rooms_prices rap ON (r.id = rap.room_id AND rap.is_default=1 AND rap.adults>0)'
                .'INNER JOIN ' . DB_PREFIX . 'rooms_prices rcp ON (r.id = rcp.room_id AND rcp.is_default=1 AND rcp.children>0)'
                . 'WHERE hotel_id = ' . (int) $id . ' AND rd.language_id="' . $lang . '"';
        return $this->db->select($sql);
    }

    function getRoomInfo($id, $lang = LANG) {
        $sql = 'SELECT * FROM ' . DB_PREFIX . 'rooms r '
                . 'JOIN ' . DB_PREFIX . 'rooms_description rd ON rd.room_id=r.id '
                . 'JOIN ' . DB_PREFIX . 'rooms_prices rp ON rp.room_id=r.id '
                . 'WHERE r.id = ' . (int) $id . ' AND rd.language_id="' . $lang . '"';
        return $this->db->selectOne($sql);
    }

    public function getBanners($section, $type, $lang = LANG) {
        $sect = $this->getSectionsByName($section);
        return $this->db->select('SELECT *,p.created_at as imgdate,s.id as sugid,p.* FROM banners s JOIN banners_description sd ON sd.banner_id=s.id JOIN banners_group bg ON bg.id=s.group JOIN photos p ON s.photo_id=p.id WHERE bg.section_id=:section AND bg.type=:type  AND sd.language_id=:lang ORDER by s.position', array('section' => $sect['home_sections_id'], 'type' => $type, 'lang' => $lang));
    }

    public function getOptions($type) {
        if ($type == 0)
            return array(
                1 => $this->lang['rural'],
                2 => $this->lang['agriculture'],
                3 => $this->lang['historical'],
                4 => $this->lang['top']
            );
        if ($type == 1)
            return array(
                1 => $this->lang['remember'],
                2 => $this->lang['savor'],
                3 => $this->lang['explore'],
                4 => $this->lang['create']
            );
    }

    public function getTypeName() {
        if ($this->type == 0)
            $this->typeName = 'accommodation';
        else if ($this->type == 1)
            $this->typeName = 'experience';
    }

}
