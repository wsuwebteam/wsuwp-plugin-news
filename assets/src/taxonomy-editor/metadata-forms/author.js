import { forwardRef, useRef, useImperativeHandle  } from 'react';
import { isEmpty, omit } from 'lodash';
import { useState, useEffect } from '@wordpress/element';

const AuthorForm = forwardRef(function(props, ref) {
	const [ metaData, setMetaData ] = useState(props.defaultValue);

	const updateMetaData = ( event ) => {
		const name = event.target.name;
		const value = event.target.value;

		if(value === ''){
			setMetaData( (prevState) => ( omit(prevState, name) )); // remove the key to avoid issues with wp api
		} else{
			setMetaData( (prevState) => ({
				...prevState,
				[name]: value
			}));
		}
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
		</>
	);
});

export default AuthorForm;

