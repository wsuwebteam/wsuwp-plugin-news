import { forwardRef, useRef, useImperativeHandle  } from 'react';
import { isEmpty } from 'lodash';
import { useState, useEffect } from '@wordpress/element';

const MediaContactForm = forwardRef(function(props, ref) {
	const [ metaData, setMetaData ] = useState({});

	const updateMetaData = ( event ) => {
		const name = event.target.name;
		const value = event.target.value;

		setMetaData( (prevState) => ({
			...prevState,
			[name]: value
		}));
	}

	useEffect(() => {
		if(!isEmpty(metaData)){
			props.onChange(metaData);
		}
	}, [metaData]);

	useImperativeHandle(ref, () => ({
		clearMetaData() {
			setMetaData({});
		}
	}));

	return (
		<>
			<label
				htmlFor={ 'editor-post-taxonomies__hierarchical-terms-organization-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-label"
			>
				Organization/Affiliation
			</label>
			<input
				name="organization"
				type="text"
				id={ 'editor-post-taxonomies__hierarchical-terms-organization-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-input"
				value={ metaData.organization || '' }
				onChange={ updateMetaData }
			/>

			<label
				htmlFor={ 'editor-post-taxonomies__hierarchical-terms-email-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-label"
			>
				Email
			</label>
			<input
				name="email"
				type="text"
				id={ 'editor-post-taxonomies__hierarchical-terms-email-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-input"
				value={ metaData.email || '' }
				onChange={ updateMetaData }
			/>

			<label
				htmlFor={ 'editor-post-taxonomies__hierarchical-terms-phone-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-label"
			>
				Phone Number
			</label>
			<input
				name="phone_number"
				type="text"
				id={ 'editor-post-taxonomies__hierarchical-terms-phone-' + props.instanceId }
				className="editor-post-taxonomies__hierarchical-terms-input"
				value={ metaData.phone_number || '' }
				onChange={ updateMetaData }
			/>
		</>
	);
});

export default MediaContactForm;

