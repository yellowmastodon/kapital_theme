/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import { __ } from '@wordpress/i18n';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

import editLinks from '../utils/link-manager';
import { useBlockProps } from '@wordpress/block-editor';
import { parseISO, getTime } from 'date-fns';
import {useEffect} from 'react';
import "./index.css";

import {
	DateTimePicker,
	Dropdown,
	Button,
	CustomSelectControl,
	__experimentalVStack as VStack,
	__experimentalHStack as HStack,
	__experimentalHeading as Heading,
	__experimentalSpacer as Spacer,
	__experimentalText as Text,
} from '@wordpress/components';
import { date } from '@wordpress/date';
import { useEntityProp } from '@wordpress/core-data';
import { closeSmall } from '@wordpress/icons';
//import { EventDateTimePicker } from './datetimePicker';
import { useRef } from 'react';

export default function edit({
	context: { postId, postType }
}) {
	const blockProps = useBlockProps();
	const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
	let eventDateStart = meta['_event_date_start'];
	let eventDateEnd = meta['_event_date_end'];
	let eventDateString = meta['_event_date_string'];

	const ISO_FORMAT = "Y-m-d\\TH:i:s";
	const SEPARATOR = ' &ndash; ';
	const NBSP_SEPARATOR = '&nbsp;&zwj;&ndash;&zwj;&nbsp;'

	const MONTHS = [
		__('január', 'kapital'),
		__('február', 'kapital'),
		__('marec', 'kapital'),
		__('apríl', 'kapital'),
		__('máj', 'kapital'),
		__('jún', 'kapital'),
		__('júl', 'kapital'),
		__('august', 'kapital'),
		__('september', 'kapital'),
		__('október', 'kapital'),
		__('november', 'kapital'),
		__('december', 'kapital'),	
	]
	const DATE_FORMAT_OPTIONS = [
		{ name: __('Dátum + čas (od-do) + rok', 'kapital'), key: 'full' },
		{ name: __('Dátum + čas (od) + rok', 'kapital'), key: 'full-start' },
		{ name: __('Dátum + rok', 'kapital'), key: 'day' },
		{ name: __('Mesiac + rok', 'kapital'), key: 'month' },
		{ name: __('Ročné obdobie + rok', 'kapital'), key: 'season' },
		{ name: __('Rok', 'kapital'), key: 'year' },
	];

	const DateDropDown = (metaKey, dropdownHeading, currentTime) => {
		currentTime = currentTime * 1000; //convert back to JS timestamp from php timestamp for render
		return (
			<Dropdown
				className="event-date"
				contentClassName="event-date-dropdown"
				popoverProps={{ placement: 'bottom-start', focusOnMount: true }}
				renderToggle={({ isOpen, onToggle }) => (
					<Button
						style={{ fontSize: '.8rem' }}
						size="default"
						variant="tertiary"
						onClick={onToggle}
						aria-expanded={isOpen}
					>
						{date('d. m. Y H:i', currentTime)}
					</Button>
				)}
				renderContent={({ isOpen, onToggle }) =>
					<div style={{ padding: '8px', minWidth: '320px' }}>
						<VStack spacing={4}>
							<HStack alignment="start">
								<Heading
									className="block-editor-inspector-popover-header__heading"
									level={2}
									size={13}
								>{dropdownHeading}
								</Heading>
								<Spacer />
								<Button
									size={"compact"}
									icon={closeSmall}
									tooltipPosition="middle left"
									className="block-editor-inspector-popover-header__action"
									label={__('Zatvoriť', "kapital")}
									onClick={onToggle}
								>
								</Button>
							</HStack>
							<DateTimePicker
								is12Hour={false}
								currentDate={date(ISO_FORMAT, new Date(currentTime))}
								onChange={(newDate) => {
									saveDate(getTime(parseISO(newDate)), metaKey)
								}} />
						</VStack>
					</div>}
			/>
		)
	}
	const DisplayDate = (timestampStart, timestampEnd,  format)=>{
		let displayDate = '';
		let dateStart = new Date(timestampStart * 1000); //back to js timestamp
		let dateEnd = new Date(timestampEnd * 1000); //back to js timestamp
		let timeStart = date('G:i', dateStart);
		let timeEnd = date('G:i', dateEnd);
		let dayStart = date('j.', dateStart);
		let dayEnd = date('j.', dateEnd);
		let monthStart = MONTHS[Number(date('n', dateStart)) - 1];
		let monthEnd = MONTHS[Number(date('n', dateEnd)) - 1];
		let yearStart = date('Y', dateStart);
		let yearEnd = date('Y', dateEnd);

		switch(format){
			case 'full':
				if (dayStart + monthStart + yearStart  ===  dayEnd + monthEnd + yearEnd){
					if (timeStart === timeEnd ){
						displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart + ' ' + timeStart;
					} else {
						displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart + ' ' + timeStart + NBSP_SEPARATOR + timeEnd;
					}
				} else if (monthStart + yearStart === monthEnd + yearEnd){
					displayDate = dayStart + NBSP_SEPARATOR + dayEnd + ' ' + monthStart + ' ' + yearStart + ' ' + timeStart + NBSP_SEPARATOR + timeEnd;
				} else if (yearStart === yearEnd){
					displayDate = dayStart + '&nbsp;' + monthStart + SEPARATOR + dayEnd + '&nbsp;' + monthEnd + ' ' + yearStart + ' ' + timeStart + NBSP_SEPARATOR + timeEnd;
				} else {
					displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart + ' ' + timeStart + SEPARATOR + dayEnd + ' ' + monthEnd + ' ' + yearEnd + ' ' + timeEnd;
				}
				break;
			case 'full-start':
				displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart + ' ' + timeStart;
				break;
			case 'day':
				if (dayStart + monthStart + yearStart  ===  dayEnd + monthEnd + yearEnd){
					displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart;
				} else if (monthStart + yearStart === monthEnd + yearEnd){
					displayDate = dayStart + NBSP_SEPARATOR + dayEnd + ' ' + monthStart + ' ' + yearStart;
				} else if (yearStart === yearEnd){
					displayDate = dayStart + '&nbsp;' + monthStart + SEPARATOR + dayEnd + ' ' + monthEnd + ' ' + yearEnd;
				} else {
					displayDate = dayStart + '&nbsp;' + monthStart + ' ' + yearStart + SEPARATOR + dayEnd + ' ' + monthEnd + ' ' + yearEnd;
				}
				break;
			case 'month':
				if (monthStart + yearStart === monthEnd + yearEnd){
					displayDate = monthStart + ' ' + yearStart;
				} else if (yearStart === yearEnd){
					displayDate = monthStart + SEPARATOR + monthEnd + ' ' + yearStart;
				} else {
					displayDate = monthStart + yearStart + SEPARATOR + monthEnd + ' ' + yearEnd;
				}
				break;
			case 'season':
				let season = [ date('m-d', dateStart), date('m-d', dateEnd)]
				
				season.forEach((date, index)=>{
					if (date >= '12-01'){
						season[index] = __("koniec roka", "kapital");
					} else if(date >= '09-23'){
						season[index] = __("jeseň", "kapital");
					} else if (date >= '06-21' ){
						season[index] = __("leto", "kapital");
					} else if (date >= '03-20' ){
						season[index] = __("jar", "kapital");
					} else {
						season[index] = __("začiatok roka", "kapital");
					}
					if (season[0] + yearStart === season[1] + yearEnd){
						displayDate = season[0] + ' ' +  yearStart;
					} else if(yearStart === yearEnd){
						displayDate = season[0] + SEPARATOR + season[1] + ' ' + yearStart;
					} else {
						displayDate = season[0] + ' ' + yearStart + SEPARATOR + season[1] + ' ' + yearEnd;
					}
				});
				
				break;
			case 'year': 
				if (yearStart === yearEnd){
					displayDate = yearStart;
				} else {
					displayDate = yearStart + SEPARATOR + yearEnd;
				}
				break;
		}
		return JSON.stringify({displayDate: displayDate, format: format});
	}

	const saveDate = (newDate, postMetaName) => {
		newDate = Math.floor(newDate * 0.001); //convert js timestamp to php timestamp
		if (postMetaName === '_event_date_start'){
			if (eventDateEnd < newDate){
				setMeta({ ...meta, ['_event_date_end']: newDate, ['_event_date_start']: newDate, ['_event_date_string']: DisplayDate(newDate, newDate, eventDateString.format) });
			} else {
				setMeta({ ...meta, ['_event_date_start']: newDate, ['_event_date_string']: DisplayDate(newDate, eventDateEnd, eventDateString.format) });
			}
		} else {
			if (newDate < eventDateStart){
				setMeta({ ...meta, [postMetaName]: eventDateStart, ['_event_date_string']: DisplayDate(eventDateStart, eventDateEnd, eventDateString.format)});
			} else {
				setMeta({ ...meta, [postMetaName]: newDate, ['_event_date_string']: DisplayDate(eventDateStart, newDate, eventDateString.format) });
			}
		}
	}

	//initialize when meta not set
	let shouldInitializeMeta = false;
	if (typeof eventDateStart === 'undefined' || eventDateStart === '' || eventDateStart === 0) {
		eventDateStart = Math.floor(getTime(new Date()) * 0.001); //php timestamp convert
		shouldInitializeMeta = true;
	}
	if (typeof eventDateEnd === 'undefined' || eventDateEnd === '' || eventDateEnd === 0) {
		eventDateEnd = Math.floor(getTime(new Date() * 0.001)); //php timestamp convert
		shouldInitializeMeta = true;
	}
	if (typeof eventDateString === 'undefined' || eventDateString === '') {
		eventDateString = JSON.parse(DisplayDate(eventDateStart, eventDateEnd, 'full-start'));
		shouldInitializeMeta = true;
	} else {
		eventDateString = JSON.parse(eventDateString);
		shouldInitializeMeta = true;
	}
	//this parsing and restringifying is quite ugly. needs refactoring
	useEffect(()=>{
		if (shouldInitializeMeta){
			setMeta({...meta, ['_event_date_start']: eventDateStart, ['_event_date_end']: eventDateEnd, ['_event_date_string']: JSON.stringify(eventDateString)})
		}
    }, [])

	return (
		<div {...blockProps}>
			<table className="kapital-event-date-table">
				<thead><tr><th style={{ fontWeight: "normal", fontSize: '1.2rem' }} colSpan="2">{__("Dátum a čas podujatia", "kapital")}</th></tr></thead>
				<tbody style={{ verticalAlign: "middle", lineHeight: "1", fontSize: "0.8rem" }}>

					<tr>
						<td>
							{__("Od", "kapital")}
						</td>


						<td>
							{
								DateDropDown('_event_date_start', __("Začiatok podujatia",  "kapital"), eventDateStart)
							}
						</td>
					</tr>
					<tr>
						<td>
							{__("Do", "kapital")}
						</td>
						<td>
							{
								DateDropDown('_event_date_end', __("Koniec podujatia", "kapital"), eventDateEnd)								
							}
						</td>
					</tr>
					<tr>
						<td >
							{__('Formát', 'kapital')}
						</td>
						<td className="kapital-event-date-format">
							<div>

								<CustomSelectControl
									hideLabelFromVision={true}
									label={__('Formát', 'kapital')}
									multiple={false}
									value={DATE_FORMAT_OPTIONS.find((option) => option.key === eventDateString.format)}
									id="kapital-event-select"
									options={DATE_FORMAT_OPTIONS}
									onChange={(newValue) => { setMeta({ ...meta, '_event_date_string': DisplayDate(eventDateStart, eventDateEnd, newValue.selectedItem.key) }) }}
									variant="minimal"
								/>
							</div>
						</td>
						<td dangerouslySetInnerHTML={{__html: eventDateString.displayDate}}>
						</td>
					</tr>

				</tbody>
			</table>
			{
				editLinks(postType, '_event_location',
					[{ name: "", url: "" }],
					__("Miesto podujatia", "kapital"),
					"",
					{
						linkPlaceholder: __("Miesto", "kapital"),
						urlPlaceholder: __("Url miesta", "kapital"),
						removeLink: __("Odstrániť miesto", "kapital"),
						addLink: __("Pridať miesto", "kapital")
					})
			}
		</div>



	);
}


